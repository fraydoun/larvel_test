<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Components\services\charge\ChargeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\services\internet\InternetRequest;
use App\Models\Factor;
use App\Repositories\FactorRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternetController extends Controller
{
    private $factor;
    private $payment;
    public function __construct(FactorRepository $factor, PaymentRepository $payment)
    {
        $this->factor   = $factor;
        $this->payment  = $payment;
    }

        /**
     * لیست بسته های اینترنت
     */
    /**
     * @api {post} /api/v1/services/internet/packages لیست بسته های اینترنت
     * @apiGroup Services
     * @apiName internet packages
     * @apiHeader  {String} Authorization توکن احراز هویت . (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 2: Unauthorized;
     *  HTTP/1.1 401 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "message": [
                    "احراز هویت نشده اید"
                ],
                "results": null,
                "code": 401
            }
        }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "MTN":{
                        "credit":{...},
                        "permanent": {...}
                    },
                   "MCI":{
                        "credit":{...},
                        "permanent": {...}
                    },
                   "RTL":{
                        "credit":{...},
                        "permanent": {...}
                    },
                   "SHT":{
                        "credit":{...},
                        "permanent": {...}
                    },
                },
                "code": 200
            }
        }
     */
    public function packages(Request $request){
        $service = ChargeService::getInstance()->products();
        if($service->requestIsOk()){
            return $this->successResponse($service->response()['products']['internet']);
        }
        return $this->customErrorResponse(null, [$service->response()['msg']], 422);
    }

    /**
     * دریافت لینک خرید بسته اینترنت
     */
    /**
     * @api {post} /api/v1/services/internet/payment-link لینک پرداخت بسته
     * @apiGroup Services
     * @apiName internet payment link
     * @apiParam {integer} product_id ایدی بسته اینترنت  (required)
     * @apiParam {string} mobile  شماره تلفن همراه (required)
     * @apiParam {string} sim_type (credit, permanent )  (اعتباری - دایمی)نوع سیمکارت (required)
     * @apiParam {string} operator (MTN, MCI, RTL, SHT) نام اپراتور(required)
     * @apiParam {string} internet_type (hourly, daily, weekly, monthly, yearly, amazing, TDLTE) (required)
     * @apiHeader  {String} Authorization توکن احراز هویت . (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "ایدی بسته الزامی میباشد",
                    "اپراتور الزامی میباشد",
                    "شماره تلفن الزامی میباشد",
                    "نوع بسته اینترنت الزامی میباشد",
                    "نوع سیمکارت باید مشخص شود",
                    "فرمت شماره تلفن صحیح نمیباشد"
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error 2: Unauthorized;
     *  HTTP/1.1 401 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "message": [
                    "احراز هویت نشده اید"
                ],
                "results": null,
                "code": 401
            }
        }
     *
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": {
                    "url": "https://inax.ir/pay.php?tid=422572"
                },
                "result": null,
                "code": 200
            }
        }
     */
    public function paymentLink(InternetRequest $request){
        $service = ChargeService::getInstance()->products();
        if(! $service->requestIsOk()){
            return $this->customErrorResponse(null, [$service->response()['msg']], 422);
        }

        try{
            $package = $service->response()['products']['internet'][$request->operator][$request->sim_type][$request->internet_type][$request->product_id];
        }catch(\Exception $e){
            $package = false;
        }
        

        if(! $package){
            return $this->customErrorResponse(null, ['بسته مورد نظر یافت نشد'], 422);
        }

        $dataFactor = [
            'owner' => Auth::id(),
            'creator' => Auth::id(),
            'type' => Factor::TYPE_SYSTEM,
            'type' => Factor::STATUS_NOT_PAY,
            'item_type' => Factor::ITEM_TYPE_CHARGE_MOBILE,
            'item_id' => null,
            'count' => 1,
            'title' => 'خرید بسته اینترنت ( ' .$package['name']. ' )',
            'price' => $package['amount'],
            'pay_data' => json_encode($package)
        ];
        $factor = $this->factor->create($dataFactor);

        $internetData = array_merge($request->all(), [
            'order_id' => $factor->id,
            'callback' => route('payment.callback.services', ['fid' => $factor->id]),
        ]);

        $service->internet($internetData);
        if(! $service->requestIsOk()){
            return $this->customErrorResponse(null, [$service->response()['msg']], 422);
        }
        
        $payment = $this->payment->create([
            'type_bank' => 1,
            'pay_data' => $service->response(),
            'payer' => Auth::id(),
            'status' => Factor::STATUS_NOT_PAY
        ]);

        $payment->relFactors()->attach($factor);

        return $this->successResponse(null, [ 'url' => $service->linkPayment() ] );



    }
}
