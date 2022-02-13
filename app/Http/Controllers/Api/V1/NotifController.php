<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\notif\CreateNotifRequest;
use App\Http\Requests\notif\InfoRequest;
use App\Models\Notification;
use App\Notifications\notif\CreateNotification;
use App\Repositories\BuildingRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UnitRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotifController extends Controller
{
    private $building;
    private $unit;
    private $notif;

    public function __construct(BuildingRepository $building, UnitRepository $unit, NotificationRepository $notif){
        $this->building = $building;
        $this->unit = $unit;
        $this->notif = $notif;
    }


    /**
     * @api {post} /api/v1/notification/create ایجاد اطلاعیه برای کاربران یک ساختمان
     * @apiGroup Notification
     * @apiName Create
     * @apiParam {integer} building_id ایدی ساختمان (required)
     * @apiParam {string} users ایدی کاربران داخل ساختمان . اگر ارسال نشود برای همه اعضا ایجاد میشود (optional)
     * @apiParam {string} title عنوان  (required)
     * @apiParam {string} message  متن پیام (required)
     * @apiParam {file} file فایل (optional)
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
                    "ایدی ساختمان الزامی میباشد",
                    "فرمت ارسالی ایدی کاربر ها درست نمیباشد",
                    "عنوان الزامی میباشد",
                    "متن پیام الزامی میباشد",
                    "حداقل کرکتر های عنوان ۳ کرکتر میباشد",
                    "فرمت های قابل قبول jpeg, png, jpg, zip, rar"
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
     * @apiErrorExample {json} Not Found: users not in building
     * HTTP/1.1 403 Forbidden
        {
            "data": {
                "status": "error",
                "messages": [
                    "بعضی از کاربر ها در این ساختمان نیستند لطفا لیست کاربر هارا تصحیح کنید"
                ],
                "results": null,
                "code": 403
            }
        }
     * @apiErrorExample {json} Service Unavailable
     * HTTP/1.1 503 Service Unavailable
        {
            "data": {
                "status": "error",
                "messages": [
                    "اطلاعیه ایجاد نشد مجدد امتحان کنید"
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
                "messages": "اطلاعیه با موفقیت ایجاد شد",
                "result": null,
                "code": 200
            }
        }
     */
    public function create(CreateNotifRequest $request){
        $building = $this->building->findById($request->get('building_id'));
        $sender = Auth::user();
        if(!$sender->can('isManager', $building)){
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }
        if(! $building){
            throw new NotFoundHttpException('ساختمان مورد نظر یافت نشد');
        }

        // get clean users from client
        $users = json_decode($request->get('users'), true);
        if(empty($users)){
            $target_users = $building->relResidents()->select('users.id', 'users.token_fcm')->get()->toArray();
        }else{
            $target_users = $building->relResidents()->whereIn('users.id', $users)->select('users.id', 'users.token_fcm')->get()->toArray();
            if(count($users) != count($target_users)){
                throw new AccessDeniedHttpException('بعضی از کاربر ها در این ساختمان نیستند لطفا لیست کاربر هارا تصحیح کنید');
            }
        }

        // upload if send file.
        $pathFile = null;
        if($file = $request->file('file')){
            $pathFile = $this->notif->uploadFile($file, $building);
        }


        // create data for insert to db.
        $data = [];
        $notif = [
            'title' => $request->get('title'),
            'message' => $request->get('message'),
            'sender' => $sender->id,
            'file' => $pathFile,
            'type' => Notification::TYPE_NOTIFICATION,
            'created_at' => $this->notif->getModel()->freshTimestamp(),
            'updated_at' => $this->notif->getModel()->freshTimestamp(),

        ];
        foreach($target_users as $user){
            $notif['receiver'] = $user['id'];
            $data[] = $notif;
        }
        unset($notif['sender'], $notif['receiver'], $notif['token_fcm']);


        if($this->notif->insert($data)){
            $tokens = Arr::pluck($target_users, 'token_fcm');

            FacadesNotification::send(null, new CreateNotification($notif, $tokens));
            return $this->successResponse(null, ['اطلاعیه با موفقیت ایجاد شد']);

        }
        return $this->customErrorResponse(null, ['اطلاعیه ایجاد نشد مجدد امتحان کنید'], 503);
    }


     /**
     * @api {post} /api/v1/notification/list دریافت لیست همه اطلاعیه های کاربر
     * @apiGroup Notification
     * @apiName list
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
                "result": {
                    "current_page": 1,
                    "data": [
                        {
                            "id": 3,
                            "title": "پرداخت نقدی فاکتور",
                            "message": " فاکتور با عنوان *خرید کی",
                            "senderInfo": {
                                "id": 0,
                                "fullName": "سیستمی"
                            }
                        },
                        {
                            "id": 12,
                            "title": "ارسال اطلاعیه تست",
                            "message": " فاکتور با عنوان *خرید کی",
                            "senderInfo": {
                                "id": 0,
                                "fullName": "سیستمی"
                            }
                        }
                    ],
                    "first_page_url": "http://blog.test/api/v1/notification/list?page=1",
                    "from": 1,
                    "last_page": 2,
                    "last_page_url": "http://blog.test/api/v1/notification/list?page=2",
                    "links": [
                        {
                            "url": null,
                            "label": "&laquo; Previous",
                            "active": false
                        },
                        {
                            "url": "http://blog.test/api/v1/notification/list?page=1",
                            "label": "1",
                            "active": true
                        },
                        {
                            "url": "http://blog.test/api/v1/notification/list?page=2",
                            "label": "2",
                            "active": false
                        },
                        {
                            "url": "http://blog.test/api/v1/notification/list?page=2",
                            "label": "Next &raquo;",
                            "active": false
                        }
                    ],
                    "next_page_url": "http://blog.test/api/v1/notification/list?page=2",
                    "path": "http://blog.test/api/v1/notification/list",
                    "per_page": 10,
                    "prev_page_url": null,
                    "to": 10,
                    "total": 18
                },
                "code": 200
            }
        }
     */
    public function getMyNotif(Request $request){
        $notifs = Auth::user()->relReceiveNotifs()->select('id','title', DB::raw('SUBSTRING(message, 1, 25) as message'), 'sender', 'created_at')->paginate(10);
        
        return $this->successResponse($notifs);
    }


    /**
     * @api {post} /api/v1/notification/info اطلاعات کامل یک اطلاعیه
     * @apiGroup Notification
     * @apiName info
     * @apiParam {integer} notif_id ایدی ساختمان (required)
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
                    "ایدی اطلاعیه الزامی میباشد",
                ],
                "results": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} NotFound: notification NotFound.
     *  HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "اطلاعیه مورد نظر یافت نشد"
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
     * @apiSuccessExample Success-Response: code is for building
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": {
                    "id": 13,
                    "receiver": 1,
                    "title": "ارسال اطلاعیه تست",
                    "message": "این یک اطلاعیه تستی است که میخواهیم تست بکنیم",
                    "file": null,
                    "action": null,
                    "seen": 1,
                    "created_at": null,
                    "updated_at": "2021-10-01T20:21:51.000000Z",
                    "senderInfo": {
                        "id": 1,
                        "fullName": "عباس جعفری"
                    }
                },
                "code": 200
            }
        }
     */
    public function getInfoNotif(InfoRequest $request){
        $notif = $this->notif->findByField('id', $request->get('notif_id'))->first();
        if(! $notif){
            throw new NotFoundHttpException('اطلاعیه مورد نظر یافت نشد');
        }

        if($notif->receiver == Auth::id() || $notif->sender == Auth::id()){
            
            if($notif->receiver == Auth::id() && $notif->seen == Notification::NOT_READ){
               
                $res = $notif->update(['seen' => Notification::READ]);
            }
    
            return $this->successResponse($notif);
        }else{
            throw new AccessDeniedHttpException('شما به این بخش دسترسی ندارید');
        }

    }
}
