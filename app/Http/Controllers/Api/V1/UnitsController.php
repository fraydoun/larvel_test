<?php

namespace App\Http\Controllers\Api\V1;

use App\Components\sms\Sms;
use App\Http\Controllers\Controller;
use App\Http\Requests\unit\CreateGroupRequest;
use App\Http\Requests\unit\CreateRequest;
use App\Http\Requests\unit\InactiveRequest;
use App\Http\Requests\unit\InfoRequest;
use App\Http\Requests\unit\UpdateRequest;
use App\Models\Building;
use App\Models\Resident;
use App\Models\Unit;
use App\Notifications\unit\NotifCreate;
use App\Repositories\BuildingRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnitsController extends Controller
{
    private $unit;
    private $building;
    private $user;
    private $sms;
    public function __construct(
        UnitRepository $repository,
        BuildingRepository $building,
        UserRepository $user,
        Sms $sms
    )
    {
        $this->unit = $repository;
        $this->building = $building;
        $this->user = $user;
        $this->sms = $sms;
    }


    /**
     * @api {post} /api/v1/unit/single-create create single unit.
     * @apiGroup Unit
     * @apiName Single Create
     * @apiParam {string} title عنوان واحد (required)
     * @apiParam {integer} building_id  ایدی ساختمان. (required)
     * @apiParam {integer} charge  مقدار شارژ واحد !-- this field access just for manager --! (optional) (required if send day_charge)
     * @apiParam {integer} day_charge روز هر ماه برای سر رسید شارژ !-- this field access just for manager --! (required if set charge)
     * @apiParam {string} phone_number شماره تلفن ساکن که در این واحد سکنا میگزیند !-- this field for manager --! (optional)
     * @apiParam {integer} living_people  تعداد نفراتی که داخل واحد زندگی میکند(optional)
     * @apiParam {integer} count_parkings  تعداد پارکینگ هایی که این واحد استفاده میکند(optional)
     * @apiParam {integer} number_floor این واحد در کدام طبقه قرار دارد(optional)
     * @apiParam {integer} number_warehouse تعداد انباری هایی که این واحد استفاده میکند(optional)
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                    "عنوان الزامی میباشد",
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error 2: building not Found;
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
     * @apiErrorExample  {json} Error 3: cant create unit for this user.
     * Http/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "messages": [
                    "کاربر قبلا در یک واحد از ساختمان فعلی ثبت شده و امکان ثبت ندارد"
                ],
                "result": null,
                "code": 403
            }
        }
     * @apiErrorExample  {json} Error 4: when set charge must set day_charge.
     * Http/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید"
                ],
                "results": null,
                "code": 422
            }
        }
     * @apiErrorExample  {json} Error 5: other errors for day_charge
     * Http/1.1 422 Unprocessable Entity
        {
            "data": {
            "status": "error",
            "messages": [
                "روز سر رسید شارژ باید یک عدد باشد",
                "کمترین مقدار روز سر رسید شارژ ۱ میباشد",
                "روز سر رسید شارژ نباید بیشتر از31 باشد"
            ],
            "results": null,
            "code": 422
            }
        }
     * @apiErrorExample  {json} Error 6: when set day_charge must set charge.
     * Http/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                "زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید"
                ],
                "results": null,
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
                    "unit": {
                        "title": "test",
                        "building_id": "2",
                        "updated_at": "2021-08-14T20:57:46.000000Z",
                        "created_at": "2021-08-14T20:57:46.000000Z",
                        "id": 44,
                        "code": "u97466644"
                    }
                },
                "code": 200
            }
        }
     */
    public function create(CreateRequest $request){
        $data = $request->all();
        $phone_number = $data['phone_number'] ?? false;
        $building = $request->building;

        list($status, $result) = $this->createUnit($data, $building, $phone_number);

        if(!$status){
            return $result;
        }

        return $this->successResponse(['unit' => $result->toArray()], null, 200);
    }


    /**
     * @api {post} /api/v1/unit/group-create create group unit.
     * @apiGroup Unit
     * @apiName Group Create
     * @apiParamExample {json} Request-Example:
    {
        "building_id":1,
        "units":[
            {
                "title": "unit1",
                "charge":20000,
                "day_charge": 3,
                "living_people": 2,
                "count_parkings":0,
                "number_floor": 3,
                "number_warehouse":0,
                "phone_number": ""
            },
            {
                "title": "unit2",
                "charge":20000,
                "day_charge": 3,
                "living_people": 2,
                "count_parkings":0,
                "number_floor": 3,
                "number_warehouse":0,
                "phone_number":"09369164186"
            },
            {
                "title": "unit3",
                "charge":20000,
                "day_charge": 3,
                "living_people": 2,
                "count_parkings":0,
                "number_floor": 3,
                "number_warehouse":0
            }
        ]
    }
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
    {
    "Authorization": "Bearer {TOKEN}"
    }
     *
     *
     * @apiErrorExample {json} Error 1: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                   "دیتای ارسالی صحیح نیست لطفا بعد از بررسی اطلاعات ارسالی  مجدد امتحان کنید"
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error 2: building not Found;
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
     * @apiErrorExample {json} Error 3: You not access;
     *  HTTP/1.1 404 Not Found
    {
        "data": {
            "status": "error",
            "messages": [
                "شما برای این بخش دسترسی لازم را ندارید"
            ],
            "results": null,
            "code": 403
        }
    }
     *     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
    {
        "data": {
            "status": "success",
            "messages": null,
            "result": [
                {
                "title": "unit1",
                "charge": 20000,
                "day_charge": 3,
                "living_people": 2,
                "count_parkings": 0,
                "number_floor": 3,
                "number_warehouse": 0,
                "building_id": 1,
                "updated_at": "2021-09-05T19:15:17.000000Z",
                "created_at": "2021-09-05T19:15:17.000000Z",
                "id": 39,
                "code": "u1739"
                },
                {
                "title": "unit3",
                "charge": 20000,
                "day_charge": 3,
                "living_people": 2,
                "count_parkings": 0,
                "number_floor": 3,
                "number_warehouse": 0,
                "building_id": 1,
                "updated_at": "2021-09-05T19:15:17.000000Z",
                "created_at": "2021-09-05T19:15:17.000000Z",
                "id": 41,
                "code": "u1741"
                }
            ],
            "code": 200
        }
    }
     */
    public function createGroup(CreateGroupRequest $request){
        $unitsData = $request->get('units');
        $building  = $request->building;
        $units = [];
        foreach($unitsData as $data){
            $phone_number = $data['phone_number'] ?? false;
            list($status, $result) = $this->createUnit($data, $building, $phone_number);

            if(!$status){
                // resident has unit.
                continue;
            }
            $units[] = $result->toArray();
        }
        return $this->successResponse($units);

    }

    /**
     * پروسه ساخت یک واحد همراه با ارسال کد به ساکن در صورت وجود شماره تلفن
     *
     */
    private function createUnit(array $data, Building $building, $phone_number = null){
        $isManager    = Auth::user()->can('isManager', $building);
        // check creator is manager so added resident to unit if set phone_number..
        if($isManager){
            if($phone_number && Auth::user()->phone_number != $phone_number) {
                $user = $this->user->findOrCreate($phone_number);
            }else{
                $user = false;
            }
        }else{ // this user not manager and just a resident that create unit by herself.
            $user = Auth::user();
        }
        $unit = $this->unit->create($data);
        
        /** @var User $user */
        if($user){
            if($this->user->hasUnitInBuilding($user, $building)){
                // unit must not create.
                $unit->forceDelete();
                return [false, $this->customErrorResponse(null, ['کاربر قبلا در یک واحد از ساختمان فعلی ثبت شده و امکان ثبت ندارد'], 403)];
            }

            // if user joined in building but not join in unit . so update record in resident.
            if($residentInBuilding = $user->relBuildings()->wherePivot('building_id', $building->id)->first()){
                $residentInBuilding->relResidents()->updateExistingPivot($user->id, ['unit_id' => $unit->id]);
            }else{
                // create new record in resiednt table.
                $unit->relResidents()->attach($user->id, ['type'=>Resident::TYPE_RESIDENT, 'building_id' => $building->id], false);
            }
            if($isManager && $user){
                $user->notify(new NotifCreate($unit));
            }
        }

        return [true, $unit];
    }
    /**
     * @api {post} /api/v1/unit/info get full info about unit.
     * @apiGroup Unit
     * @apiName Info
     * @apiParam {integer} unit_id ایدی واحد (required)
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                "ایدی واحد الزامی میباشد",
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error 2: unit not found
     *  HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "واحد مورد نظر در سیستم یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample  {json} Error 3: not access this section.
     * Http/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "messages": [
                    "شما دسترسی برای این بخش را ندارید"
                ],
                "result": null,
                "code": 403
            }
        }

     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
    {
        "data": {
            "status": "success",
            "messages": null,
            "result": {
                "id": 1,
                "title": "test",
                "building_id": 1,
                "living_people": null,
                "count_parkings": null,
                "number_parking": null,
                "number_warehouse": null,
                "number_floor": null,
                "charge": 1000,
                "day_charge": 27,
                "code": "u841",
                "created_at": "2021-08-25T14:26:24.000000Z",
                "updated_at": "2021-08-25T14:26:24.000000Z",
                "debt": "1000",
                "rel_building": {
                    "id": 1,
                    "name": "testdd",
                    "unit": null,
                    "floor": null,
                    "manager": 1,
                    "wallet": 0,
                    "name_owner_bank": "abbass",
                    "last_name_owner_bank": "jafari",
                    "code": "b671",
                    "created_at": "2021-08-25T14:26:07.000000Z",
                    "updated_at": "2021-08-25T14:26:07.000000Z"
                },
                "factors": [
                    {
                    "id": 3,
                    "title": "شارژ  شهریور ماه ۱۴۰۰",
                    "owner": 1,
                    "creator": 1,
                    "price": 1000,
                    "type": 1,
                    "status": 1,
                    "item_type": 1,
                    "item_id": 1,
                    "count": 1,
                    "part": {
                        "id": 1,
                        "title": "تعمیرات"
                    },
                    "payment_deadline": "2021-09-06 01:40:28",
                    "created_at": "2021-08-26T21:10:28.000000Z",
                    "updated_at": "2021-08-26T21:10:28.000000Z"
                    }
                ],
                
            },
            "code": 200
        }
    }
     */
    public function info(InfoRequest $request){
        /** @var Unit $unit */
        $unit = $this->unit->findById($request->get('unit_id'));
        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر در سیستم یافت نشد');
        }

        $building = $unit->relBuilding;

        $user = Auth::user();

        $access =  $user->can('isResident', $unit) || $user->can('isManager', $building); # current user is resident in unit or is building's manager.

        if(! $access){
            throw new AccessDeniedHttpException('شما دسترسی برای این بخش را ندارید');
        }


        $arrayDataUnit = $unit->toArray();
        $arrayDataUnit['factors'] = $unit->relFactors()->limit(10)->get();
        return $this->successResponse($arrayDataUnit);
    }

    /**
         * @api {post} /api/v1/unit/factors get full list factors one unit.
         * @apiGroup Unit
         * @apiName Factors
         * @apiParam {integer} unit_id ایدی واحد (required)
         * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                    "ایدی واحد الزامی میباشد",
                ],
                "results": null,
                    "code": 422
                }
            }
         *
         * @apiErrorExample {json} Error 2: unit not found
         *  HTTP/1.1 404 Not Found
            {
            "data": {
            "status": "error",
            "messages": [
                "واحد مورد نظر در سیستم یافت نشد"
            ],
            "results": null,
            "code": 404
            }
            }
         *
         * @apiErrorExample  {json} Error 3: not access this section.
         * Http/1.1 403 Forbidden
            {
            "data": {
            "status": "error",
            "messages": [
            "شما دسترسی برای این بخش را ندارید"
            ],
            "result": null,
            "code": 403
            }
        }

         * @apiSuccessExample Success-Response:
         *  HTTP/1.1 200 OK
            {
                "data": {
                        "status": "success",
                        "messages": null,
                        "result": {
                        "current_page": 1,
                        "data": [
                            {
                                "id": 3,
                                "title": "شارژ  شهریور ماه ۱۴۰۰",
                                "owner": 1,
                                "creator": 1,
                                "price": 1000,
                                "type": 1,
                                "status": 1,
                                "item_type": 1,
                                "item_id": 1,
                                "count": 1,
                                "part": {
                                    "id": 1,
                                    "title": "تعمیرات"
                                },
                                "payment_deadline": "2021-09-06 01:40:28",
                                "created_at": "2021-08-26T21:10:28.000000Z",
                                "updated_at": "2021-08-26T21:10:28.000000Z"
                            }
                        ],
                        "first_page_url": "http://blog.test/api/v1/unit/factors?page=1",
                        "from": 1,
                        "last_page": 1,
                        "last_page_url": "http://blog.test/api/v1/unit/factors?page=1",
                        "links": [
                            {
                                "url": null,
                                "label": "&laquo; Previous",
                                "active": false
                            },
                            {
                                "url": "http://blog.test/api/v1/unit/factors?page=1",
                                "label": "1",
                                "active": true
                            },
                            {
                                "url": null,
                                "label": "Next &raquo;",
                                "active": false
                            }
                        ],
                        "next_page_url": null,
                        "path": "http://blog.test/api/v1/unit/factors",
                        "per_page": 10,
                        "prev_page_url": null,
                        "to": 1,
                        "total": 1
                    },
                    "code": 200
                }
            }
     */
    public function factors(InfoRequest $request){
        /** @var Unit $unit */
        $unit = $this->unit->findById($request->get('unit_id'));
        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر در سیستم یافت نشد');
        }

        $building = $unit->relBuilding;

        $user = Auth::user();

        $access =  $user->can('isResident', $unit) || $user->can('isManager', $building); # current user is resident in unit or is building's manager.

        if(! $access){
            throw new AccessDeniedHttpException('شما دسترسی برای این بخش را ندارید');
        }
        $factors = $unit->relFactors()->paginate(10);
        return $this->successResponse($factors);
    }


        /**
         * @api {post} /api/v1/unit/remove/{unit_id} Remove an Unit.
         * @apiGroup Unit
         * @apiName Remove
         * @apiParam {integer} unit_id ایدی واحد (required)
         * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                    "ایدی واحد الزامی میباشد",
                ],
                "results": null,
                    "code": 422
                }
            }
         *
         * @apiErrorExample {json} Error 2: unit not found
         *  HTTP/1.1 404 Not Found
            {
                "data": {
                    "status": "error",
                    "messages": [
                        "واحد مورد نظر در سیستم یافت نشد"
                    ],
                    "results": null,
                    "code": 404
                }
            }
         *
         * @apiErrorExample  {json} Error 3: not access this section.
         * Http/1.1 403 Forbidden
            {
            "data": {
                "status": "error",
                "messages": [
                "شما دسترسی برای این بخش را ندارید"
                ],
                "result": null,
                "code": 403
            }
        }

         * @apiSuccessExample Success-Response:
         *  HTTP/1.1 200 OK
           {
                "data": {
                    "status": "success",
                    "messages": [
                        "واحد با موفقیت حذف شد"
                    ],
                    "result": null,
                    "code": 200
                }
            }
     */
    public function delete(Request $request, $unit_id){
        /** @var Unit $unit */
        $unit = $this->unit->findByField('id', $unit_id)->first();
        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر در سیستم یافت نشد');
        }

        if(! Auth::user()->can('isManager', $unit->relBuilding)){
            throw new AccessDeniedHttpException('شما دسترسی برای این بخش ندارید');
        }

        // soft delete
        $res = $unit->delete();

        if($res){
            return $this->successResponse(null, ['واحد با موفقیت حذف شد']);
        }

        return $this->customErrorResponse(null, ['مشلکلی در حذف واحد اتفاق افتاده لطفا مجدد امتحان کنید'], 503);
    }

    
            /**
         * @api {post} /api/v1/unit/inactive-resident inactive current resident one unit.
         * @apiGroup Unit
         * @apiName inActive
         * @apiParam {integer} unit_id ایدی واحد (required)
         * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                        "ایدی واحد الزامی میباشد",
                    ],
                    "results": null,
                    "code": 422
                }
            }
         *
         * @apiErrorExample {json} Error 2: unit not found
         *  HTTP/1.1 404 Not Found
            {
            "data": {
            "status": "error",
            "messages": [
                "واحد مورد نظر در سیستم یافت نشد"
            ],
            "results": null,
            "code": 404
            }
            }
         *
         * @apiErrorExample  {json} Error 3: not access this section.
         * Http/1.1 403 Forbidden
            {
                "data": {
                    "status": "error",
                    "messages": [
                        "شما دسترسی برای این بخش را ندارید",
                        "این واحد کاربر فعالی ندارد"
                    ],
                    "result": null,
                    "code": 403
                }
            }
         * @apiErrorExample {json} Error 4: not done!
         * Http/1.1 503 Server Unavilable
            {
                "data": {
                    "status": "error",
                    "messages": [
                        'عملیات  انجام نشد مجدد امتحان کنید'
                    ],
                    "result": null,
                    "code": 503
                }
            }
         * @apiSuccessExample Success-Response:
         *  HTTP/1.1 200 OK
           {
                "data": {
                    "status": "success",
                    "messages": [
                        "ساکن با موفقیت در این واحد غیر فعال شد"
                    ],
                    "result": null,
                    "code": 200
                }
            }
     */
    public function inactiveResident(InactiveRequest $request){
        /** @var Unit $unit */
        $unit = $this->unit->findByField('id', $request->get('unit_id'))->first();
        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر یافت نشد');
        }

        $building = $unit->relBuilding;

        if(! Auth::user()->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما دسترسی برای این بخش ندارید');
        }

        $activeResident = $unit->activeResident();
        if(! $activeResident){
            throw new AccessDeniedHttpException('این واحد کاربر فعالی ندارد');
        }

        if($unit->relResidents()->updateExistingPivot($activeResident->id, ['status' => Resident::STATUS_DEACTIVE])){
            return $this->successResponse(null, ['ساکن با موفقیت در این واحد غیر فعال شد']);
        }

        return $this->customErrorResponse(null, ['عملیات  انجام نشد مجدد امتحان کنید'], 503);
    }


        /**
     * @api {post} /api/v1/unit/update update one unit.
     * @apiGroup Unit
     * @apiName Update
     * @apiParam {integer} unit_id ایدی واحد (required)
     * @apiParam {string} title عنوان واحد (optional)
     * @apiParam {integer} charge  مقدار شارژ واحد  (optional) 
     * @apiParam {integer} day_charge روز هر ماه برای سر رسید شارژ (optional)
     * @apiParam {integer} living_people  تعداد نفراتی که داخل واحد زندگی میکند(optional)
     * @apiParam {integer} count_parkings  تعداد پارکینگ هایی که این واحد استفاده میکند(optional)
     * @apiParam {integer} number_floor این واحد در کدام طبقه قرار دارد(optional)
     * @apiParam {integer} number_warehouse تعداد انباری هایی که این واحد استفاده میکند(optional)
     * @apiHeader  {String} Authorization Authorization value. (Bearer Token)
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
                    "ایدی ساختمان الزامی میباشد",
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error 2: building not Found;
     *  HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "واحد مورد نظر یافت نشد"
                ],
                "results": null,
                "code": 404
            }
        }
     *
     * @apiErrorExample  {json} Error 3: Access Deny!.
     * Http/1.1 403 Access Deny!
        {
            "data": {
                "status": "error",
                "messages": [
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
                    "واحد با موفقیت بروز رسانی شد"
                ],
                "result": {
                    "id": 5,
                    "title": "این واحد منه",
                    "building_id": 2,
                    "living_people": 4,
                    "count_parkings": 4,
                    "number_parking": 55,
                    "number_warehouse": 44,
                    "number_floor": 4,
                    "charge": 444444,
                    "day_charge": 4,
                    "code": "u145",
                    "created_at": "2021-10-12T17:36:54.000000Z",
                    "updated_at": "2021-10-12T18:03:05.000000Z",
                    "deleted_at": null,
                    "debt": 0,
                    "rel_active_resident": null,
                    "rel_building": {
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
                    }
                },
                "code": 200
            }
        }
     */
    public function update(UpdateRequest $request){
        $unit = $this->unit->findById($request->get('unit_id'));
        if(! $unit){
            throw new NotFoundHttpException('واحد مورد نظر یافت نشد');
        }

        if(! Auth::user()->can('update', $unit)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }

        $unit->update($request->all());

        return $this->successResponse($unit->refresh(), ['واحد با موفقیت بروز رسانی شد']);
    }
}
