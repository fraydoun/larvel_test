<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Components\services\charge\ChargeService;
use App\Components\services\charge\Inax;
use App\Http\Controllers\Controller;
use App\Http\Requests\services\charge\TopupRequest;
use App\Models\Factor;
use App\Repositories\FactorRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    private $factor;
    private $payment;

    public function __construct(FactorRepository $repo, PaymentRepository $payRepo)
    {
        $this->factor = $repo;
        $this->payment = $payRepo;
    }

    /**
     * خرید شارژ مستقیم برای اپراتور های ایرانسل . همراه اول . . رایتل
     */
    /**
     * @api {post} /api/v1/services/charge/topup خرید شارژ سیمکارت
     * @apiGroup Services
     * @apiName topup
     * @apiParam {string} operator نام اپراتور (MTN, MCI, RTL, SHT) (required)
     * @apiParam {integer} amount مبلغ شارژ (required)
     * @apiParam {string} phone_number  شماره تلفن همراه (required)
     * @apiParam {string} charge_type (normal, amazing, mnp, )  نوع شارژ (معمولی ، شگفت انگیز)(required)
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
                    "یک اپراتو ابتدا مشخص کنید",
                    "مبلغ شارژ باید وارد شود",
                    "شماره تلفنی که میخواهید شارژ بشود را وارد کنید",
                    "نوع شارژ باید ارسال شود"
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
     * @apiErrorExample {json} Error 3: 3th aplication errors
     *  HTTP/1.1 401 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "باتوجه به اعلام اپراتور ایرانسل، شارژ شگفت انگیز  1,000 و 2,000 تومانی ارائه نمی شود.",
                    "امکان شارژ شگفت انگیز همراه اول وجود ندارد",
                    "شماره موبایل 09156017178 با اپراتور ایرانسل تناسب ندارد . لطفا شماره موبایل یا اپراتور را اصلاح نمائید...."
                ],
                "result": null,
                "code": 422
            }
        }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                   "url": "https://inax.ir/pay.php?tid=406780"
                },
                "code": 200
            }
        }
     */
    public function topup(TopupRequest $request){
        $data = $request->all();
        $data = array_merge([
            'owner' => Auth::id(),
            'creator' => Auth::id(),
            'type' => Factor::TYPE_SYSTEM,
            'type' => Factor::STATUS_NOT_PAY,
            'item_type' => Factor::ITEM_TYPE_CHARGE_MOBILE,
            'item_id' => null,
            'count' => 1,
            'title' => 'خرید شارژ',
            'price' => $request->get('amount'),
            'pay_data' => json_encode([
                'operator' => $request->get('operator'),
                'phone_number' => $request->get('phone_number'),
                'charge_type' => $request->get('charge_type')
            ])
        ], $data);



        $factor = $this->factor->create($data);

        $data = [
            'operator' => $request->operator,
            'amount'   => $request->amount,
            'mobile'   => $request->phone_number,
            'charge_type' => $request->charge_type,
            'order_id' => $factor->id,
            'pay_type' => Inax::PAY_TYPE_ONLINE,
            'callback' => route('payment.callback.services', ['fid' => $factor->id])
        ];
        $service = ChargeService::getInstance()->topup($data);
        
        if($service->requestIsOk()){
            $payment = $this->payment->create([
                'type_bank' => 1,
                'pay_data' => $service->response(),
                'payer' => Auth::id(),
                'status' => Factor::STATUS_NOT_PAY
            ]);
    
            $payment->relFactors()->attach($factor);

            return  $this->successResponse(['url' => $service->linkPayment()]);
        }else{
            return $this->customErrorResponse(null, [$service->response()['msg']], 422);
        }
        
    }


    
}

