<?php

namespace App\Http\Controllers\Api\V1\Services;

use App\Components\services\charge\ChargeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\services\bill\BillPaymentRequest;
use App\Models\Factor;
use App\Repositories\FactorRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    private $factor;
    private $payment;

    public function __construct(FactorRepository $repo, PaymentRepository $payRepo)
    {
        $this->factor = $repo;
        $this->payment = $payRepo;
    }

        /**
     * پرداخت قبوض اب ،برق ، گاز ...
     */
    /**
     * @api {post} /api/v1/services/bill/url-payment پرداخت قبوض
     * @apiGroup Services
     * @apiName bill
     * @apiParam {integer} bill_id شناسه قبض (required)
     * @apiParam {integer} pay_id شناسه پرداخت (required)
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
                    "شناسه قبض الزامی میباشد",
                    "شناسه پرداخت الزامی میباشد"
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
                "messages": null,
                "result": {
                    "code": 1,
                    "trans_id": 413963,
                    "url": "https://inax.ir/pay.php?tid=413963",
                    "msg": "عملیات موفق",
                    "type_en": "elec",
                    "type_fa": "برق",
                    "amount": 59800,
                    "pay_type": "online"
                },
                "code": 200
            }
        }
     */
    public function bill(BillPaymentRequest $request){
        $checkBillService = ChargeService::getInstance()->checkBill($request->all());

        if(! $checkBillService->requestIsOk()){
            return $this->customErrorResponse(null, [$checkBillService->response()['msg']], 422);
        }
        $billData = $checkBillService->response();
        
        $data = [
            'owner'     => Auth::id(),
            'creator'   => Auth::id(),
            'type'      => Factor::TYPE_SYSTEM,
            'type'      => Factor::STATUS_NOT_PAY,
            'item_type' => Factor::ITEM_TYPE_BILL_PAYMENT,
            'item_id'   => null,
            'count'     => 1,
            'title'     => 'پرداخت قبض ' . $billData['type_fa'],
            'price'     => $billData['amount'],
            'pay_data'  => json_encode($billData)
        ];

        $factor = $this->factor->create($data);
        $billRequestData = [
            'bill_id'   => $request->bill_id,
            'pay_id'    => $request->pay_id,
            'order_id'  => $factor->id,
            'mobile'    => Auth::user()->phone_number,
            'callback'  => route('payment.callback.services', ['fid' => $factor->id])
        ];

        $billService = ChargeService::getInstance()->bill($billRequestData);
        if($billService->requestIsOk()){
            $payment = $this->payment->create([
                'type_bank' => 1,
                'pay_data' => $billService->response(),
                'payer' => Auth::id(),
                'status' => Factor::STATUS_NOT_PAY
            ]);
    
            $payment->relFactors()->attach($factor);

            return $this->successResponse($billService->response());
        }else{
            return $this->customErrorResponse(null, [$billService->response()['msg']], 422);
        }
    }
}
