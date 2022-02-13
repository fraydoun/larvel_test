<?php

namespace App\Http\Controllers\Api\V1;

use App\Components\paymentGateway\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\payment\ListPaymentsBuildingRequest;
use App\Http\Requests\payment\ManualPaymentConfirmationRequest;
use App\Http\Requests\payment\ManualPaymentRequest;
use App\Http\Requests\payment\SetPayemntRequest;
use App\Models\Building;
use App\Models\Factor;
use App\Models\Payment;
use App\Models\Unit;
use App\Notifications\factor\NotifConfirmationManaulPayment;
use App\Notifications\factor\NotifPaymentManual;
use App\Repositories\FactorRepository;
use App\Repositories\PaymentRepository;
use Exception;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PaymentController extends Controller
{
    private $factor;
    private $payment;
    public function __construct(FactorRepository $factor, PaymentRepository $payment)
    {
        $this->factor  = $factor;
        $this->payment = $payment;
    }


    /**
     * @api {post} /api/v1/payment/list-gates لیست درگاه های پرداخت
     * @apiGroup Payment
     * @apiName list Gates
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
        "Authorization": "Bearer {TOKEN}"
        }
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": [
                    {
                        "id": 1,
                        "name": "zarinPal",
                        "title": "ذرین پال",
                        "icon": ""
                    }
                ],
                "code": 200
            }
        }
     */
    public function listGates(Request $request){
        return $this->successResponse(Payment::listGates());
    }



     /**
     * @api {post} /api/v1/payment/request درخواست برای پرداخت اینترنت فاکتور ها
     * @apiParam {integer} gate_id ایدی درگاهی که قرار است پرداخت شود (required)
     * @apiParam {string} factor_ids لیست ایدی های فاکتور هایی که قرار است پرداخت شود (required)
     * @apiParam {string} device یکی از مقادیر (android, web, ios)
     * @apiGroup Payment
     * @apiName Request
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
        "Authorization": "Bearer {TOKEN}"
        }
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "ایدی درگاه پرداخت الزامی میباشد",
                    "فرمت ارسالی فاکتور ها صحیح نمیباشد",
                    "فاکتوری برای پرداخت باید انتخاب شود",
                    "نوع دیوایس باید مشخص شود (web, android, ios)"
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Access Denied
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "message": [
                    "بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید"
                ],
                "result": null,
                "code": 403
            }
        }
     
     * @apiErrorExample {json} Service Unavilable
     * HTTP/1.1 503 Unavilable
        {
            "data": {
                "status": "error",
                "message": [
                    "خطایی اتفاق افتاده لطفا مجدد امتحان کنید"
                ],
                "result": null,
                "code": 503
            }
        }
     * @apiSuccessExample Success-Response: return url payment
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "url": "http://blog.test/payment/start-pay/jRfnM"
                },
                "code": 200
            }
        }
     */
    public function requestPayment(SetPayemntRequest $request){
        $factor_ids = json_decode($request->get('factor_ids'), true);
        $factors = $this->factor->getCurrentUserFactorsForPay($factor_ids);
        
        if(count($factor_ids) != count($factors)){
            throw new AccessDeniedHttpException('بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید');
        }
        
        $payment = $this->payment->create([
            'type_bank' => $request->get('gate_id'),
            'payer' => Auth::id(),
            'status' => Factor::STATUS_NOT_PAY,
            'pay_data' => ['device' => $request->get('device')]
        ]);
        
        $payment->relFactors()->attach($factors->pluck('id')->toArray());
        
        $gateWay = Gateway::getInstance($payment);
        
        $status = $gateWay->request(['callback' => route('payment.verify'), 'callbackParams' => ['payment_id' => $payment->id]]);
        if(! $status){
            throw new ServiceUnavailableHttpException('خطایی اتفاق افتاده لطفا مجدد امتحان کنید');
        }

        $hash = (new Hashids())->encode([Auth::id(), $payment->id]);
        return $this->successResponse(['url' => route('payment.redirectToGateway', ['token' => $hash])]);
    }


    /**
     * @api {post} /api/v1/payment/manual-payment پرداخت نقدی فاکتور
     * @apiParam {integer} unit_id ایدی واحد کاربر (requrired)
     * @apiParam {string} factor_ids لیست ایدی های فاکتور هایی که قرار است پرداخت شود (required)
     * @apiParam {string} description توضیحات از سمت کاربر برای پرداخت نقدی (optional)
     * @apiParam {file} document سندی که مشخص میکند پرداخت نقدی هست این سند عکس میباشد(optional)
     * @apiGroup Payment
     * @apiName Manual Payment
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
        "Authorization": "Bearer {TOKEN}"
        }
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "ایدی واحد الزامی میباشد",
                    "فرمت ارسالی فاکتور ها صحیح نمیباشد",
                    "فاکتوری برای پرداخت باید انتخاب شود",
                    "عکس باید یک فایل باشد",
                    "فرمت های قابل قبول jpeg, png, jpg",
                    "",
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Access Denied
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "message": [
                    "بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید"
                ],
                "result": null,
                "code": 403
            }
        }
     
     * @apiErrorExample {json} Service Unavilable
     * HTTP/1.1 503 Unavilable
        {
            "data": {
                "status": "error",
                "message": [
                    "خطایی اتفاق افتاده لطفا مجدد امتحان کنید"
                ],
                "result": null,
                "code": 503
            }
        }
     * @apiSuccessExample Success-Response: return url payment
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": 'درخواست با موفقیت ثبت شد و پس از تایید مدیر پرداخت  تکمیل میشود',
                "result": null,
                "code": 200
            }
        }
     */
    public function manualPayment(ManualPaymentRequest $request){
        $unit = Unit::find($request->get('unit_id'));

        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر یافت نشد');
        }

        $factor_ids = json_decode($request->get('factor_ids'), true);
        $factors = $this->factor->getCurrentUserFactorsForPay($factor_ids, Factor::ITEM_TYPE_UNIT, $unit->id);


        
        if(count($factor_ids) != count($factors)){
            throw new AccessDeniedHttpException('بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید');
        }


        $payData = $request->has('description')? ['description' => $request->get('description')]: [];
        $payment = $this->payment->create([
            'type_bank' => Payment::PYMENT_MANUAL_TYPE_BANK,
            'payer' => Auth::id(),
            'status' => Factor::STATUS_WAITE_CONFIRM_BY_MANAGER,
            'pay_data' => $payData
        ]);

        $payment->relFactors()->attach($factors->pluck('id')->toArray());
        $payment->relFactors()->update(['status' => Factor::STATUS_WAITE_CONFIRM_BY_MANAGER]);
        // save if send document .
        if($document = $request->file('document')){
            $document = $this->payment->uploadDocument($document, $payment);
            $payData['document'] = [$document]; // چون بعدا امکان داره چنتا فایل بفرسته فعلا اینجا تو ارایه میزاریم ساختار رو داشته باشیم
            $payment->pay_data = $payData;
            $payment->save();
        }

        // Auth::user()->notify(new NotifPaymentManual($payment, $unit->relBuilding->relManager));
        Notification::send($unit->relBuilding->relManager, new NotifPaymentManual($payment));
        return $this->successResponse(null, ['درخواست با موفقیت ثبت شد و پس از تایید مدیر پرداخت  تکمیل میشود']);

    }

    /**
     * @api {post} /api/v1/payment/list-payment-manual لیست پرداختی هایی که منتظر تایید مدیر هستند
     * @apiParam {integer} building_id ایدی ساختمان (requrired)
     * @apiGroup Payment
     * @apiName List Payment Manual
     * @apiDescription 
     * لیست همه درخواستی هایی که برای پرداخت نقدی توسط کاربران یک ساختمان ثبت شده است
     * 
     * به اینصورت که کاربر یک یا چند فاکتور را انتخاب میکند که برای پرداخت دستی (نقدی) ثبت کند
     * 
     * این فاکتور ها همه در قالب یک پرداختی در سرور ثبت میشود
     * 
     *  پس هر پرداختی شامل تعدادی فاکتور ،اطلاعات پرداختی و وضعیت میباشد
     * 
     * کد وضعیت ها که هم برای فاکتور ها و هم برای درخواست پرداختی ها یکسان میباشد شامل: 
     * 
     * 1 :  منتظر پرداخت
     * 
     * 2 : پرداخت شده 
     * 
     * 3 :  منتظر تایید مدیر
     * 
     * 4 : رد شده توسط مدیر
     * 
     * 
     * در این سرویس فقط لیست پرداختی هایی داده میشود که کد وضعیت آنها 3 باشد
     * 
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
        "Authorization": "Bearer {TOKEN}"
        }
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                   "ایدی ساختمان الزامی میباشد"
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} building Not Found
     * HTTP/1.1 404 NotFound!
        {
            "data": {
                "status": "error",
                "message": [
                    "ساختمان مورد نظر یافت نشد"
                ],
                "result": null,
                "code": 404
            }
        }
     * @apiErrorExample {json} Access Denied
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "message": [
                    "شما دسترسی لازم برای عملیات در این بخش را ندارید"
                ],
                "result": null,
                "code": 403
            }
        }

     * @apiSuccessExample Success-Response: return url payment
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": [
                    {
                        "id": 8,
                        "type_bank": 0,
                        "pay_data": {
                            "description": "this is test for test",
                            "document": [
                                "/storage/photos/payment/document-8.png"
                            ]
                        },
                        "payer": 2,
                        "status": 3,
                        "created_at": "2021-10-05T09:40:53.000000Z",
                        "updated_at": "2021-10-05T09:40:53.000000Z",
                        "status_label": "منتظر تایید مدیر",
                        "rel_payer": {
                            "id": 2,
                            "first_name": "عباس",
                            "last_name": "جعفری",
                            "fullName": "عباس جعفری"
                        },
                        "rel_factors": [
                            {
                                "id": 1,
                                "title": "هزینه های اضافی شب جشن",
                                "description": "خرید کیک و شیرینی و تنقلات اضافه",
                                "owner": 2,
                                "creator": 1,
                                "price": 50000,
                                "type": 2,
                                "status": 3,
                                "item_type": 1,
                                "item_id": 1,
                                "count": 1,
                                "part": {
                                    "id": 1,
                                    "title": "تعمیرات"
                                },
                                "payment_deadline": null,
                                "created_at": "2021-10-02T20:30:30.000000Z",
                                "updated_at": "2021-10-07T10:43:09.000000Z"
                            },
                            {
                                "id": 2,
                                "title": "هزینه های اضافی شب جشن",
                                "description": "خرید کیک و شیرینی و تنقلات اضافه",
                                "owner": 2,
                                "creator": 1,
                                "price": 50000,
                                "type": 2,
                                "status": 1,
                                "item_type": 1,
                                "item_id": 1,
                                "count": 1,
                                "part": {
                                    "id": 1,
                                    "title": "تعمیرات"
                                },
                                "payment_deadline": null,
                                "created_at": "2021-10-02T20:30:37.000000Z",
                                "updated_at": "2021-10-05T20:34:53.000000Z"
                            }
                        ]
                    },
                    {
                        "id": 9,
                        "type_bank": 0,
                        "pay_data": {
                            "description": "this is test for test",
                            "document": [
                                "/storage/photos/payment/document-9.png"
                            ]
                        },
                        "payer": 2,
                        "status": 3,
                        "created_at": "2021-10-07T10:43:09.000000Z",
                        "updated_at": "2021-10-07T10:43:09.000000Z",
                        "status_label": "منتظر تایید مدیر",
                        "rel_payer": {
                            "id": 2,
                            "first_name": "عباس",
                            "last_name": "جعفری",
                            "fullName": "عباس جعفری"
                        },
                        "rel_factors": [
                            {
                                "id": 1,
                                "title": "هزینه های اضافی شب جشن",
                                "description": "خرید کیک و شیرینی و تنقلات اضافه",
                                "owner": 2,
                                "creator": 1,
                                "price": 50000,
                                "type": 2,
                                "status": 3,
                                "item_type": 1,
                                "item_id": 1,
                                "count": 1,
                                "part": {
                                    "id": 1,
                                    "title": "تعمیرات"
                                },
                                "payment_deadline": null,
                                "created_at": "2021-10-02T20:30:30.000000Z",
                                "updated_at": "2021-10-07T10:43:09.000000Z"
                            }
                        ]
                    }
                ],
                "code": 200
            }
        }
     */
    public function listPaymentsManual(ListPaymentsBuildingRequest $request){
        $building = Building::find($request->get('building_id'));

        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        
        if(!Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما دسترسی لازم برای عملیات در این بخش را ندارید');
        }

        $payments = $this->payment->getListManualPaymentsBuilding($building);

        return $this->successResponse($payments);
    }

    
    /**
     * @api {post} /api/v1/payment/manual-payment-confirmation تایید یا رد یک پرداختی که کاربر از طریق نقدی زده است
     * @apiParam {integer} unit_id ایدی واحد که پرداختی در ان صورت گرفته (required)
     * @apiParam {integer} payment_id ایدی پرداختی (requrired)
     * @apiParam {integer} confirmation وضعیت پرداختی (required) if == 0 reject and == 1 accept
     * @apiGroup Payment
     * @apiName Manual payment confrimation
     * @apiDescription 
     * بعد اینکه کاربر پرداخت دستی یا همان نقدی را زد نوتیفیکیشنی برای مدیر ارسال میشود با مضمون اینکه کاربر فلان فاکتور هارا 
     * 
     * نقدی پرداخت کرده است در صورتی که میخواهید تایید کنید به بخش پرداختی ها بروید
     * 
     * بعد اینکه مدیر به بخش پرداختی ها میرود و لیست پرداختی هایی که بصورت نقدی پرداخت شده و هنوز تایید نشده را میبیند
     * 
     * میتواند هر کدام را تایید کند که باید درخواست تایید ان را به این سرویس ارسال کنید
     * 
     * پارامتر confirmation شامل مقدار: 
     * 
     * 0: رد شده
     * 
     * 1: تایید شده 
     * 
     * میباشد.
     * 
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
        "Authorization": "Bearer {TOKEN}"
        }
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "ایدی واحد الزامی میباشد",
                    "ایدی پرداخت الزامی میباشد",
                    "کد تایید الزامی میباشد"
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} building Not Found
     * HTTP/1.1 404 NotFound!
     * @apiErrorExample {json} Access Denied
        {
            "data": {
                "status": "error",
                "message": [
                    "واحد مورد نظر یافت نشد",
                    "پرداختی با این ایدی یافت نشد"
                ],
                "result": null,
                "code": 404
            }
        }
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "message": [
                    "شما دسترسی لازم برای عملیات در این بخش را ندارید"
                ],
                "result": null,
                "code": 403
            }
        }

     * @apiSuccessExample Success-Response: return url payment
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": "عملیات با موفقیت انجام شد",
                "result": null
                "code": 200
            }
        }
     */
    public function manualPaymentConfirmation(ManualPaymentConfirmationRequest $request){
        $unit = Unit::find($request->get('unit_id'));
        if(!$unit){
            throw new NotFoundHttpException('واحد مورد نظر یافت نشد');
        }

        $payment = $this->payment->findById($request->get('payment_id'));
        if(! $payment){
            throw new NotFoundHttpException('پرداختی با این ایدی ثبت نشده است');
        }

        $building = $unit->relBuilding;

        if(!Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما برای انجام این عملیات دسترسی ندارید');
        }


        switch ($request->get('confirmation')) {
            case 1:
                $statusCode = Factor::STATUS_PAYED;
                break;
            case 0: 
                $statusCode = Factor::STATUS_REJECT_CONFIRM_BY_MANAGER;
                break;
            default:
                $statusCode = Factor::STATUS_NOT_PAY;
                break;
        }

        $payment->changeStatus($statusCode);
        
        Notification::send($payment->relPayer, new NotifConfirmationManaulPayment($payment));

        return $this->successResponse(null, ['عملیات با موفقیت انجام شد']);
        


    }
}
