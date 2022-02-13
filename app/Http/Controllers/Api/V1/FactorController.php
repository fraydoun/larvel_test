<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\factor\BuyChargeRequest;
use App\Http\Requests\factor\CreateRequest;
use App\Http\Requests\factor\RemoveRequest;
use App\Models\Building;
use App\Models\Factor;
use App\Models\Unit;
use App\Notifications\factor\NotifCreate;
use App\Repositories\BuildingRepository;
use App\Repositories\FactorRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UnitRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification ;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class FactorController extends Controller
{
    private $factor;
    private $unit;
    private $building;
    private $payment;

    public function __construct(FactorRepository $factor, UnitRepository $unit, BuildingRepository $building, PaymentRepository $payment)
    {
        $this->factor = $factor;
        $this->unit   = $unit;
        $this->building = $building;
        $this->payment = $payment;
    }

    /**
     * @api {post} /api/v1/factor/create ایجاد فاکتور جدید برای ساکنان واحد ها
     * @apiGroup Factor
     * @apiName Create
     * @apiParam {integer} building_id ایدی ساختمان (required)
     * @apiParam {string} units ایدی واحد ها (required)
     * @apiParam {string} title عنوان فاکتور (required)
     * @apiParam {string} description توضیحات فاکتور (optional)
     * @apiParam {integer} price قیمت فاکتور (required)
     * @apiParam {integer} status وضعیت فاکتور {optional} default = 1
     * @apiParam {integer} part مشخص کننده کدوم قسمت (لیستش یک سرویس دیگه داره در قسمت public) 
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
                    "اید واحد الزامی است",
                    "ایدی واحد های مد نظر را باید بفرستید",
                    "عنوان فاکتور الزامی میباشد",
                    "هزینه فاکتور را باید بفرستید",
                    "حداقل کارکتر های عنوان باید 5 حرف باشد",
                    "حداکثر کارکتر های عنوان باید 150 حرف باشد",
                    "به دلیل عدم وجود ساکن در واحد های مد نظر فاکتوری ایجاد نشده است"
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} NotFound: Building NotFound.
     *  HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} No Access
     * HTTP/1.1 403 Forbidden
        {
            "data": {
            "status": "error",
            "messages": [
                "شما به این بخش دسترسی ندارید"
            ],
            "result": null,
            "code": 403
        }
     *
     * @apiErrorExample {json} Not Found: some units not found.
     * HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "بعضی از واحد ها در سیستم ثبت نشده است . لطفا بررسی نمایید"
                ],
                "results": null,
                "code": 404
            }
        }
     * @apiErrorExample {json} Service Unavailable
     * HTTP/1.1 503 Service Unavailable
        {
            "data": {
                "status": "error",
                "messages": [
                    "مشکل ناشناخته بوجود امده و فاکتور ها ایجاد نشد"
                ],
                "results": null,
                "code": 503
            }
        }
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
    {
        "data": {
            "status": "success",
            "messages": null,
            "result": [
                {
                    "title": "هزینه های اضافی شب جشن",
                    "discription": "",
                    "price": "50000",
                    "item_id": 1,
                    "item_type": 1,
                    "owner": 1,
                    "type": 2,
                    "creator": 1,
                    "updated_at": "2021-09-01T19:31:28.000000Z",
                    "created_at": "2021-09-01T19:31:28.000000Z",
                    "id": 13
                },
                {
                    "title": "هزینه های اضافی شب جشن",
                    "discription": "",
                    "price": "50000",
                    "item_id": 2,
                    "item_type": 1,
                    "owner": 1,
                    "type": 2,
                    "creator": 1,
                    "updated_at": "2021-09-01T19:31:28.000000Z",
                    "created_at": "2021-09-01T19:31:28.000000Z",
                    "id": 13
                }
            ],
            "code": 200
        }
    }
     */
    public function create(CreateRequest $request){
        $data = $request->all();

        /** @var Building $building */
        $building = $this->building->findById($data['building_id']);

        if(!$building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(! Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }


        $units = json_decode($data['units'], true);
        unset($data['units']);


        // if empty units ids so create factor for all units in buildin.
        if(empty($units)){
            $unitModels = $building->relUnits;
        }else{
            $unitModels = $this->unit->findWhereIn('id', $units)->where('building_id', $building->id);
            if(count($units) !== count($unitModels)){
                throw new NotFoundHttpException('بعضی از واحد ها در ساختمان ثبت نشده اند . لطفا بررسی نمایید');
            }
        }


        $countCreated = 0;
        $factors = [];
        $users   = [];
        DB::beginTransaction();
        foreach($unitModels as $key => $unit){
            /** @var Unit $unit */
            $activeResident = $unit->activeResident();


            // if not has active Resident so not create factor.
            if(! $activeResident) {
                unset($unitModels[$key]);
                continue;
            }

            $factor = $this->factor->createForUnit($unit, $data, $activeResident->id);
            if($factor){
                $countCreated ++;
                $factors[] = $factor;
                $users[] = $activeResident;
            }
        }

        if($countCreated != count($unitModels)){
            DB::rollBack();
            return $this->customErrorResponse(null, ['مشکل ناشناخته بوجود امده و فاکتور ها ایجاد نشد'], 503);
        }

        DB::commit();


        // چون به این قسمت رسیده و فاکتوری ایجاد نشده یعنی واحد های مورد نظر ساکنی نداشتند
        if(empty($factors)){
            return $this->customErrorResponse(null, ['به دلیل عدم وجود ساکن در واحد های مد نظر فاکتوری ایجاد نشده است'], 422);
        }
        // send message
        // SendNotifCreate::dispatch($factors, $users);
        Notification::send(null, new NotifCreate($factors, $users));
        return $this->successResponse($factors);
    }


    /**
     * @api {post} /api/v1/factor/delete حذف فاکتور
     * @apiGroup Factor
     * @apiName Delete
     * @apiParam {integer} factor_id ایدی فاکتور (required)
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
                    "ایدی فاکتور الزامی است",
                ],
                "results": null,
                "code": 422
            }
        }
     * @apiErrorExample {json} Not Found
     * HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                   "فاکتور مورد نظر در سیستم یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} No Access
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "messages": [
                    "شما به این بخش دسترسی ندارید"
                ],
                "result": null,
                "code": 403
            }
        }
     *
     * @apiErrorExample {json} Service Unavailable
     * HTTP/1.1 503 Service Unavailable
            {
            "data": {
                "status": "error",
                "messages": [
                    "فاکتور حذف نشد مجدد امتحان کنید"
                ],
                "results": null,
                "code": 503
            }
        }
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": [
                    'عملیات با موفقیت انجام شد'
                ],
                "result": null,
                "code": 200
            }
        }
     *
     */
    public function delete(RemoveRequest $request){
        /** @var Factor $factor */
        $factor = $this->factor->findById($request->get('factor_id'));

        if(! $factor){
            throw new NotFoundHttpException('فاکتور مورد نظر در سیستم یافت نشد');
        }

        if(! Auth::user()->can('manageFactor', $factor)){
            throw new AccessDeniedHttpException('شما برای انجام این کار دسترسی ندارید');
        }

        $status = $factor->delete();
        if(! $status){
            return $this->customErrorResponse(null, ['فاکتور حذف نشد مجدد امتحان کنید'], 503);
        }

        return $this->successResponse(null, ['عملیات با موفقیت انجام شد']);
    }


      /**
     * @api {post} /api/public/factor/list-parts list parts a factor.
     * @apiGroup Public
     * @apiName listParts
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": [
                    {
                        "id": 0,
                        "title": "شارژ ساختمان"
                    },
                    {
                        "id": 1,
                        "title": "تعمیرات"
                    },
                    {
                        "id": 2,
                        "title": "جشن"
                    }
                ],
                "code": 200
            }
        }
     *
     */
    public function listParts(Request $request){
        return $this->successResponse($this->factor->getModel()->getParts());
    }



    /**
     * @api {post} /api/v1/factor/buy-charge ثبت فاکتور خرید شارژ
     * @apiGroup Factor
     * @apiName buyCharge
     * @apiParam {string} title عنوان  (required)
     * @apiParam {integer} price مبلغ شارژ  (required)
     * @apiParam {string} description توضیحات (optional)
     * @apiParam {json} pay_data اطلاعات پرداخت(optional)
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
                    "عنوان الزامی است",
                    "مبلغ شارژ الزامی است",
                    "اطلاعات پرداختی باید رشته جیسون باشد"
                ],
                "results": null,
                "code": 422
            }
        }
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": [
                    "فاکتور خرید شارژ با موفقیت ثبت شد"
                ],
                "result": null,
                "code": 200
            }
        }
     *
     */
    public function buyCharge(BuyChargeRequest $request){
        $factor = $this->factor->create($request->all());
        $payment = $this->payment->create([
            'type_bank' => 1,
            'pay_data' => $request->get('pay_data'),
            'payer' => Auth::id(),
            'status' => Factor::STATUS_PAYED
        ]);

        $payment->relFactors()->attach($factor);

        return $this->successResponse(null, ['فاکتور خرید شارژ با موفقیت ثبت شد']);
    }
    
}
