<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\building\BuildingJoinRequest;
use App\Http\Requests\building\ChagneManagerRequest;
use App\Http\Requests\building\CreateRequest;
use App\Http\Requests\building\InfoBuildingRequest;
use App\Http\Requests\building\UpdateRequest;
use App\Models\Building;
use App\Models\Resident;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\BuildingRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BuildingController extends Controller
{
    /** @var Building $building */
    private $building;

    /** @var UnitRepository $unit */
    private $unit;

    /** @var UserRepository $user */
    private $user;

    public function __construct(
        BuildingRepository $repository,
        UnitRepository $unit,
        UserRepository $user
    )
    {
        $this->building = $repository;
        $this->unit     = $unit;
        $this->user     = $user;
    }



    /**
     * @api {post} /api/v1/building/create ایجاد یک ساختمان جدید.
     * @apiGroup Building
     * @apiName Create
     * @apiParam {string} name نام ساختمان (required)
     * @apiParam {string} sheba  شماره شبای حساب ساختمان. (required)
     * @apiParam {string} card_number  شماره کارت حساب ساختمان (required)
     * @apiParam {string} bank_number  شماره حساب بانکی ساختمان(required)
     * @apiParam {string} name_owner_bank نام صاحب حساب بانکی ساختمان.(required)
     * @apiParam {string} last_name_owner_bank نام خانوادگی حساب بانکی ساختمان.(required)
     * @apiParam {integer} unit  تعداد واحد های ساختمان(optional)
     * @apiParam {integer} floor تعداد طبقات ساختمان (optional)
     * @apiParam {string} address آدرس (optional)
     * @apiParam {integer} state ایدی استان  (optional)
     * @apiParam {integer} city ایدی شهر (optional)
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
                    "نام ساختمان الزامی است ",
                    "شماره شبا الزامی است",
                    "شماره کارت الزامی است",
                    "شماره حساب الزامی است",
                    "نام صاحب حساب الزامی است",
                    "نام خانوادگی صاحب حساب الزامی است",
                    'فرمت های قابل قبول jpeg, png, jpg',
                    ,'حجم عکس نباید بیش از 5 مگابایت باشد'
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
     * @apiErrorExample {json} Error 3: To Many Request
     * Http/1.1 429 To Many Request.
        {
            "data": {
                "status": "error",
                "message": [
                "در هر دقیقه میتوانید یک درخواست ارسال کنید"
                ],
                "results": null,
                "code": 429
            }
        }
     *
     * @apiErrorExample  {json} Error 4: Internal server Error
     * Http/1.1 500 Internal Server Error
        {
            "data": {
                "status": "error",
                "message": [
                    "مشکلی در ایجاد ساختمان پیش امده .لطفا مجدد امتحان کنید"
                ],
                "results": null,
                "code": 500
            }
        }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "building_id": 5,
                    "code": "b9721195"
                },
                "code": 200
            }
        }
     */
    public function create(CreateRequest $request)
    {
        $postData = $request->all();


        $building = $this->building->create($postData);
        if(!$building){
            return $this->customErrorResponse(null, ['مشکلی در ایجاد ساختمان پیش امده .لطفا مجدد امتحان کنید'], 500);
        }

        if($image = $request->file('image')){
            $image = $this->building->uploadImage($image, $building);
            $building->image = $image;
            $building->save();
        }
        return $this->successResponse(['building_id' => $building->id, 'code' => $building->code]);
    }



    /**
     * @api {post} /api/v1/building/join ورود به یک ساختمان یا واحد.
     * @apiGroup Building
     * @apiName Join
     * @apiParam {string} code کد واحد یا ساختمان (required)
     * @apiHeader  {String} Authorization توکن احراز هویت. (Bearer Token)
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
                    "کد واحد یا ساختمان الزامی میباشد"
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Forbidden : access denied errors
     *  HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "message": [
                    "شما قبلا در این ساختمان وارد شده اید",
                    "این واحد دارای ساکن فعال میباشد و نمیتوان وارد ان شد"
                ],
                "results": null,
                "code": 403
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
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "building": {
                        "id": 2,
                        "name": "testdd",
                        "unit": null,
                        "floor": null,
                        "manager": 1,
                        "wallet": 0,
                        "sheba": "789456123012365478954587",
                        "card_number": "1234567891234567",
                        "bank_number": "1234567891",
                        "name_owner_bank": "abbass",
                        "last_name_owner_bank": "jafari",
                        "code": "b752",
                        "created_at": "2021-08-20T08:22:55.000000Z",
                        "updated_at": "2021-08-20T08:22:55.000000Z"
                    },
                    "type": "building"
                },
                "code": 200
            }
        }
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "unit": {
                        "id": 2,
                        "name": "testdd",
                        "unit": null,
                        "floor": null,
                        "manager": 1,
                        "wallet": 0,
                        "sheba": "789456123012365478954587",
                        "card_number": "1234567891234567",
                        "bank_number": "1234567891",
                        "name_owner_bank": "abbass",
                        "last_name_owner_bank": "jafari",
                        "code": "b752",
                        "created_at": "2021-08-20T08:22:55.000000Z",
                        "updated_at": "2021-08-20T08:22:55.000000Z"
                    },
                    "type": "unit"
                },
                "code": 200
            }
        }
     */
    public function join(BuildingJoinRequest $request)
    {
        $code = $request->get('code');
        $typeModel = $request->codeIsFor(); // this return 'unit' or 'building'
        $messageType = $typeModel == 'unit'? 'واحد': 'ساختمان';

        /** @var Building  $model */
        /** @var Unit $model */
        $model = $this->{$typeModel}->findByCode($code);

        if(!$model){
            throw new NotFoundHttpException($messageType . ' با این کد یافت نشد');
        }

        if($this->user->joined($model, Auth::id())){
            throw new AccessDeniedHttpException('شما قبلا در این ' . $messageType . ' وارد شده اید');
        }

        if($typeModel == 'unit' && $model->activeResident()){
            throw new AccessDeniedHttpException('این واحد دارای ساکن فعال میباشد و نمیتوان وارد ان شد');
        }

        // data for Resident TABLE
        $dataPivotTable = [
            'status' => Resident::STATUS_ACTIVE,
            'type'  => Resident::TYPE_RESIDENT,
            'building_id' => $model->getBuildingId(),
            'unit_id' => $model instanceof Unit? $model->id: null
        ];

        // check if user want join in unit then first check join in building.
        // if joined in building just update record.
        $residentExisted = Resident::where('user_id', Auth::id())
            ->where('building_id', $model->getBuildingId())
            ->first();

        if($residentExisted){
            $residentExisted->update($dataPivotTable);
        }else{
            $model->relResidents()->attach(Auth::id(), $dataPivotTable);
        }

        return $this->successResponse([$typeModel => $model, 'type' => $typeModel]);
    }

    /**
     * @api {post} /api/v1/building/my-building ساختمان های من
     * @apiGroup Building
     * @apiName my-building
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 1: Unauthorized;
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
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": [
                    {
                        "id": 2,
                        "name": "testdd",
                        "unit": null,
                        "floor": null,
                        "manager": 1,
                        "wallet": 0,
                        "name_owner_bank": "abbass",
                        "last_name_owner_bank": "jafari",
                        "code": "b752",
                        "created_at": "2021-08-20T08:22:55.000000Z",
                        "updated_at": "2021-08-20T08:22:55.000000Z",
                        "my_role": "manager",
                        "my_unit": {
                            "id": 1,
                            "title": "test",
                            "debt": 0
                        },
                        "rel_manager": {
                            "id": 1,
                            "first_name": null,
                            "last_name": null,
                            "email": null,
                            "email_verified_at": null,
                            "national_code": null,
                            "phone_number": "09369164186",
                            "active": 0,
                            "created_at": "2021-08-15T19:36:41.000000Z",
                            "updated_at": "2021-08-15T19:36:41.000000Z"
                        }
                    }
                ],
                "code": 200
            }
        }
     */
    public function myBuilding(Request $request){
        /** @var User $user */
        $user = Auth::user();

        $myBuilding = $user->relBuildings()->with(['relManager'])->get()->append('my_unit')->toArray();
        return $this->successResponse($myBuilding);
    }




    /**
     * @api {post} /api/v1/building/list-units/{building_id} لیست واحد های یک ساختمان
     * @apiParam {string} buildin_id id of building  (required) بجای {building_id} قرار میگیرد
     * @apiGroup Building
     * @apiName list units
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 1: Unauthorized;
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
     * @apiErrorExample {json} Error 2: Not found;
     *  HTTP/1.1 404 Not Found!
        {
            "data": {
                "status": "error",
                "message": [
                "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} Error 2: Access Deny;
     *  HTTP/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "message": [
                "شما به این ساختمان دسترسی ندارید"
                ],
                "results": null,
                "code": 403
            }
        }
     *
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "units": [
                        {
                            "id": 1,
                            "title": "test",
                            "building_id": 7,
                            "living_people": null,
                            "count_parkings": null,
                            "number_parking": null,
                            "number_warehouse": null,
                            "number_floor": null,
                            "charge": 1000,
                            "day_charge": 5,
                            "code": "u511",
                            "created_at": "2021-09-12T16:29:11.000000Z",
                            "updated_at": "2021-09-12T16:29:11.000000Z",
                            "debt": "50000",
                            "rel_active_resident": {
                                "id": 2,
                                "first_name": null,
                                "last_name": null,
                                "email": null,
                                "national_code": null,
                                "phone_number": "09369164185",
                                "avatar": null,
                                "active": 0,
                                "created_at": "2021-09-12T16:29:11.000000Z",
                                "updated_at": "2021-09-12T16:29:11.000000Z"
                            }
                            
                        }
                    ]
                },
                "code": 200
            }
        }
     */
    public function listUnits(Request $request, $building_id){
        $building = $this->building->findById($building_id);
        $user = Auth::user();
        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }
        
        if(! $user->can('isInsideBuilding', $building)){
            throw new AccessDeniedHttpException('شما به این ساختمان دسترسی ندارید');
        }

        $units = $building->relUnits()->get();
        
        return $this->successResponse(['units' => $units->toArray()]);
    }


    /**
     * @api {post} /api/v1/building/full-info/{building_id} اطلاعات کامل یک ساختمان
     * @apiParam {integer} buildin_id id of building  (required) بجای {building_id} قرار میگیرد
     * @apiGroup Building
     * @apiName  Full info
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 1: Unauthorized;
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
     * @apiErrorExample {json} Error 2: Not found;
     *  HTTP/1.1 404 Not Found!
        {
            "data": {
                "status": "error",
                "message": [
                "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} Error 2: Access Deny;
     *  HTTP/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "message": [
                "شما به این ساختمان دسترسی ندارید"
                ],
                "results": null,
                "code": 403
            }
        }
     *
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "id": 1,
                    "name": "testdd",
                    "unit": 30,
                    "floor": 6,
                    "manager": 1,
                    "wallet": 50000,
                    "cash_desk": 0,
                    "state": 1,
                    "city": 3,
                    "address": "mahhad blv avini",
                    "sheba": "789456123012365478954587",
                    "card_number": "1234567891234567",
                    "bank_number": "1234567891",
                    "name_owner_bank": "abbass",
                    "last_name_owner_bank": "jafari",
                    "code": "b781",
                    "image": null,
                    "created_at": "2021-10-02T20:29:38.000000Z",
                    "updated_at": "2021-10-02T20:37:26.000000Z",
                    "my_role": "manager"
                },
                "code": 200
            }
        }
     */

    public function fullInfo(Request $request, $building_id){
        $building = $this->building->findById($building_id);

        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(!Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }

        $building->makeVisible($building->hidden);
        return $this->successResponse($building);
    }


    /**
     * @api {post} /api/v1/building/change-manager تغییر مدیر یک ساختمان
     * @apiParam {integer} buildin_id id of building  (required) 
     * @apiParam {string} phone_number_new_manager phone number new manager (required)
     * @apiParam {string} sheba sheba  bank new manager. (optional)
     * @apiParam {string} card_number  bank card number new manager (optional)
     * @apiParam {string} name_owner_bank name owner bank new manager (optional)
     * @apiParam {string} last_name_owner_bank last name owner bank new manager(optional)
     * @apiGroup Building
     * @apiName  Change Manger
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 1: Unauthorized;
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
     * @apiErrorExample {json} Error 2: Not found;
     *  HTTP/1.1 404 Not Found!
        {
            "data": {
                "status": "error",
                "message": [
                "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} Error 2: Access Deny;
     *  HTTP/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "message": [
                "شما به این بخش دسترسی نداری"
                ],
                "results": null,
                "code": 403
            }
        }
     *
     * @apiErrorExample {json} Error parameters: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "ایدی ساختمان الزامی میباشد",
                    "شماره تلفن مدیر جدید الزامی میباشد",
                    "شماره شبا 24 کرکتر است",
                    "شماره کارت 16 کرکتر است",
                    "شماره حساب ۱۰ کرکتر است"
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
                "messages": ["عملیات با موفقیت انجام شد"],
                "result": null,
                "code": 200
            }
        }
     */
    public function changeManager(ChagneManagerRequest $request){
        $building = $this->building->findById($request->get('building_id'));
        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(! Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }

        $user = $this->user->findOrCreate($request->get('phone_number_new_manager'));

        $ArrayData = $request->all();
        $ArrayData['manager'] = $user->id;

        if($building->update($ArrayData)){
            return $this->successResponse(null, ['عملیات با موفقیت انجام شد']);
        }

        return $this->customErrorResponse(null, ['مشکلی در بروز رسانی اطلاعات بوجود امده لطفا مجدد امتحان کنید'], 503);
    }  
    
    
        /**
     * @api {post} /api/v1/building/delete/{building_id} حذف یک ساختمان
     * @apiParam {integer} buildin_id id of building  (required) بجای {building_id}
     * @apiGroup Building
     * @apiName  delete
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error 1: Unauthorized;
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
     * @apiErrorExample {json} Error 2: Not found;
     *  HTTP/1.1 404 Not Found!
        {
            "data": {
                "status": "error",
                "message": [
                "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample {json} Error 2: Access Deny;
     *  HTTP/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "message": [
                "شما به این بخش دسترسی نداری"
                ],
                "results": null,
                "code": 403
            }
        }
     *
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": ["ساختمان با موفقیت حذف شد"],
                "result": null,
                "code": 200
            }
        }
     */
    public function delete(Request $request, $building_id){
        $building = $this->building->findById($building_id);

        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(! Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }

        // soft delete
        $building->delete();

        return $this->successResponse(null, ['ساختمان با موفقیت حذف شد']);
    }



    /**
     * @api {post} /api/v1/building/create ویرایش یک ساختمان
     * @apiGroup Building
     * @apiName Update
     * @apiParam {integer} building_id  ایدی ساختمان(required)
     * @apiParam {string} name نام ساختمان (optional)
     * @apiParam {string} sheba  شماره شبای حساب ساختمان. (optional)
     * @apiParam {string} card_number  شماره کارت حساب ساختمان (optional)
     * @apiParam {string} bank_number  شماره حساب بانکی ساختمان(optional)
     * @apiParam {string} name_owner_bank نام صاحب حساب بانکی ساختمان.(optional)
     * @apiParam {string} last_name_owner_bank نام خانوادگی حساب بانکی ساختمان.(optional)
     * @apiParam {integer} unit  تعداد واحد های ساختمان(optional)
     * @apiParam {integer} floor تعداد طبقات ساختمان (optional)
     * @apiParam {string} address آدرس (optional)
     * @apiParam {integer} state ایدی استان  (optional)
     * @apiParam {integer} city ایدی شهر (optional)
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
                    "نام ساختمان الزامی است ",
                    'فرمت های قابل قبول jpeg, png, jpg',
                    ,'حجم عکس نباید بیش از 5 مگابایت باشد',
                    "شماره شبا 24 کرکتر است",
                    "شماره کارت 16 کرکتر است",
                    "شماره حساب ۱۰ کرکتر است"
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
    * @apiErrorExample {json} Error 3: NotFound;
     *  HTTP/1.1 404 Not Found!
        {
            "data": {
                "status": "error",
                "message": [
                    "ساختمان مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
    * @apiErrorExample {json} Error 2: Access Deny!;
     *  HTTP/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "message": [
                    "شما به این بخش دسترسی ندارید"
                ],
                "results": null,
                "code": 403
            }
        }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": [
                    "ساختمان با موفقیت بروز رسانی شد"
                ],
                "result": {
                    "id": 2,
                    "name": "عباس",
                    "unit": 11,
                    "floor": 5,
                    "manager": 1,
                    "wallet": 0,
                    "name_owner_bank": "abbass",
                    "last_name_owner_bank": "jafari",
                    "code": "b042",
                    "image": "/storage/photos/building/image-2.png",
                    "created_at": "2021-10-12T16:50:04.000000Z",
                    "updated_at": "2021-10-12T17:08:37.000000Z",
                    "deleted_at": null,
                    "my_role": "manager"
                },
                "code": 200
            }
        }
     */
    public function update(UpdateRequest $request){
        $building = $this->building->findById($request->get('building_id'));
        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        if(! Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }
        $building->update($request->all());

        if($image = $request->file('image')){
            $image = $this->building->uploadImage($image, $building);
            $building->image = $image;
            $building->save();
        }

        return $this->successResponse($building->refresh(), ['ساختمان با موفقیت بروز رسانی شد']);
    }
}
