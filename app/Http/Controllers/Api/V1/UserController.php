<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateFcmTokenRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Http\Requests\user\UpdateRequset;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var UserRepository $user */
    private $user; 
    private $notif;
    public function __construct(UserRepository $repository, NotificationRepository $notif){
        $this->user = $repository;
        $this->notif = $notif;
    }


    /**
     * @api {post} /api/v1/users/update update information user.
     * @apiGroup User
     * @apiName Update
     * @apiParam {string} first_name user's first name (required)
     * @apiParam {string} last_name  user's last name  (required)
     * @apiParam {numeric} national_code national code user (required)
     * @apiParam {file} avatar avatar's user (optional)
     * @apiHeader  {String} Authorization Authorization value.
     * @apiHeaderExample {json} Header-Example:
      {
        "Authorization": "Bearer {TOKEN}"
      }
     *
     *
     * @apiErrorExample {json} Error1: data is not valid.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "نام الزامی میباشد",
                    "نام خانوادگی الزامی میباشد",
                    "کد ملی الزامی میباشد",
                    "کد ملی نامعتبر میباشد",
                    "کد ملی قبلا در سامانه ثبت شده است",
                    "نماد باید یک فایل باشد",
                    "نماد باید یک عکس باشد",
                    "فرمت های قابل قبول jpeg, png, jpg"
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error2: Unauthorized;
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
                        "user": {
                            "id": 1,
                            "first_name": "abbas",
                            "last_name": "jafari",
                            "email": null,
                            "email_verified_at": null,
                            "national_code": "0927421852",
                            "phone_number": "09020838954",
                            "avatar": "/storage/photos/user/avatar/user-1.png",
                            "active": 1,
                            "created_at": "2021-09-02T20:06:35.000000Z",
                            "updated_at": "2021-09-02T20:10:35.000000Z"
                        }
                },
                "code": 200
            }
        }
     */
    public function update(UpdateRequset $request){

        $updateFields = $request->all();
        $updateFields['active'] = 1;

        $isDuplicate = $this->user->isDuplicateNationalCode($request->get('national_code'));
        if($isDuplicate){
            return $this->customErrorResponse(null, ['کد ملی قبلا در سامانه ثبت شده است'], 422);
        }
        if($avatar = $request->file('avatar')){
            $avatar = $this->user->uploadAvatar($avatar, Auth::id());
            $updateFields['avatar'] = $avatar;
        }
        $user = $this->user->update($updateFields, Auth::user()->id);
        return $this->successResponse(['user' => $user->toArray()]);
    }



    /**
     * @api {post} /api/v1/users/profile get current user profile.
     * @apiGroup User
     * @apiName profile
     *  
     * @apiHeader  {String} Authorization Authorization value.
     * @apiHeaderExample {json} Header-Example:
      {
        "Authorization": "Bearer {TOKEN}"
      }
     *
     *
     * @apiErrorExample {json} Error2: Unauthorized;
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
                    "user": {
                        "id": 1,
                        "first_name": null,
                        "last_name": null,
                        "email": null,
                        "national_code": null,
                        "phone_number": "09020838954",
                        "avatar": null,
                        "active": 0,
                        "created_at": "2021-09-07T16:44:23.000000Z",
                        "updated_at": "2021-09-07T16:44:23.000000Z"
                    }
                }, 
                "code": 200
            }
        }
     */
    public function profile(Request $request){
        $user = Auth::user();

        return $this->successResponse(['user' => $user]);
    }

    
    /**
     * @api {post} /api/v1/users/get-base-info get total public info for current user.
     * @apiGroup User
     * @apiName get base info
     *  
     * @apiHeader  {String} Authorization Authorization value.
     * @apiHeaderExample {json} Header-Example:
      {
        "Authorization": "Bearer {TOKEN}"
      }
     *
     *
     * @apiErrorExample {json} Error2: Unauthorized;
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
                    "count_notif": 5,
                    "count_message": 0
                },
                "code": 200
            }
        }
     */
    public function baseInfo(Request $request){
        $countNotifNotRead = $this->notif->getCountNotRead(Notification::TYPE_NOTIFICATION);
        $countMessageNotRead = $this->notif->getCountNotRead(Notification::TYPE_PRIVATE_MESSAGE);

        return $this->successResponse([
            'count_notif' => $countNotifNotRead,
            'count_message' => $countMessageNotRead
        ]);

    }

    /**
     * @api {post} /api/v1/users/update-fcm update FCM token.
     * @apiGroup User
     * @apiName Update FCM token
     *  
     * @apiHeader  {String} Authorization Authorization value.
     * @apiHeaderExample {json} Header-Example:
      {
        "Authorization": "Bearer {TOKEN}"
      }
     *
     *
     * @apiErrorExample {json} Error2: Unauthorized;
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
                "messages": [
                    "توکن با موفقیت بروزرسانی شد"
                ],
                "result": null,
                "code": 200
            }
        }
     */
    public function updateTokenFirebase(UpdateFcmTokenRequest $request){        
        $updateField = ['token_fcm' => $request->get('token')];

        $user = $this->user->update($updateField, Auth::id());
        return $this->successResponse(null, ['توکن با موفقیت بروز رسانی شد']);
    }
}
