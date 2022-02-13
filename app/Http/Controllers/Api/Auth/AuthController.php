<?php

namespace App\Http\Controllers\Api\Auth;

use App\Components\sms\Sms;
use App\Http\Controllers\Controller;
use App\Http\Requests\user\AuthRequest;
use App\Models\Validation;
use App\Notifications\auth\SendVerificationCode;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /** @var UserRepository $user */
    private $user;

    /** @var Sms $sms */
    private $sms;

    // personal token passport
    const PersonalTokenName = 'newToken';
    public function __construct(UserRepository $repository, Sms $sms){
        $this->user = $repository;
        $this->sms  = $sms;
    }


    /**
     * @api {post} /api/auth login and recive sms code
     * @apiName auth
     * @apiGroup Auth
     * @apiParam {integer} phone_number client for recive code.
     * @apiErrorExample {json} Error1: phone_number required.
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
                    "شماره تلفن الزامی میباشد"
                ],
                "result": null,
                "code": 422
            }
        }
     * @apiErrorExample {json} Error2: length must 11 charecter
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
    "طول شماره تلفن باید 11 کارکتر باشد"
                ],
                "result": null,
                "code": 422
            }
        }
     * @apiErrorExample {json} Error3: phone_number is not correct
     *  HTTP/1.1 422 Unprocessable Entity
        {
            "data": {
                "status": "error",
                "messages": [
    "شماره تلفن بصورت صحیح وارد نشده است"
                ],
                "result": null,
                "code": 422
            }
        }
     *
     * @apiErrorExample {json} Error4: Too many Request for send code
     *  HTTP/1.1 429 Too Many Request
        {
            "data": {
                "status": "error",
                "messages": [
                "درخواست بعدی برای دریافت کد در 118 ثانیه بعد"
                ],
                "result": null,
                "code": 429
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
                    "code": 2057
                },
                "code": 200
            }
        }
     */
    public function auth(AuthRequest $request){

        $user = $this->user->findOrCreate($request->phone_number);
        $nextTimeRequest = Validation::hasValidCode();

        if($nextTimeRequest){
            return $this->customErrorResponse(null, ['درخواست بعدی برای دریافت کد در '. $nextTimeRequest . ' ثانیه بعد'], 429);
        }
        // genrate new code and send to client.
        $validation_code = Validation::genrateCode($user->id);

        $user->notify(new SendVerificationCode($validation_code));
        return $this->successResponse(['code' => $validation_code->code]);
    }



    /**
     * @api {post} /api/verify verify phone_number via sms code.
     * @apiName verify
     * @apiGroup Auth
     * @apiParam {integer} phone_number client for recive code.
     * @apiParam {integer} code  activate code that send sms client
     * @apiErrorExample {json} Error1: phone_number required.
     *  HTTP/1.1 422 Unprocessable Entity
    {
        "data": {
            "status": "error",
            "messages": [
                "شماره تلفن الزامی میباشد"
            ],
            "result": null,
            "code": 422
        }
    }
     * @apiErrorExample {json} Error2: code is required
     *  HTTP/1.1 422 Unprocessable Entity
    {
        "data": {
            "status": "error",
            "messages": [
                "کد تایید الزامی است"
            ],
            "result": null,
            "code": 422
        }
    }
     * @apiErrorExample {json} Error3: code is required
     *  HTTP/1.1 401 Unauthorized
        {
            "data": {
                "status": "error",
                "messages": [
                    "کد تایید صحیح نمیباشد"
                ],
                "result": null,
                "code": 401
            }
        }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                    "status": "success",
                    "messages": null,
                    "result": {
                    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGFhN2MwNDZhMjgwZTE4MzI5ZmZhM2RjYTZmYmZlYzU2ZGU1MWU0OWIxNDY5MzIzNjdjM2FjN2I0MWY4MjFhNGExODM2NmFiNGIxMGE5MjQiLCJpYXQiOjE2Mjg1NDA1NTguOTg1MTEwMDQ0NDc5MzcwMTE3MTg3NSwibmJmIjoxNjI4NTQwNTU4Ljk4NTExNzkxMjI5MjQ4MDQ2ODc1LCJleHAiOjE2NjAwNzY1NTguOTc2OTM4MDA5MjYyMDg0OTYwOTM3NSwic3ViIjoiMSIsInNjb3BlcyI6W119.HICu1lq-aMHC7MnY7pjz3m8jNJ32S4RzrHNYyNqPPxcFqxFTG3YUscmKMTRCi0nftxLsTCZ8noQreoj4OnFOr-q8CIE2TIyW9JRz0lHcXUqEH1jyykmYDRPz9DtAcr2WWRZOI1D2fwDImr38rNJfYiPe32BynvGntwwRMKHQgT_T3Xj_uP9L9l48pKQCRAXd0Gt0MQpTIt0K-N4w3LFhZkSiis-W0WbOa1wogWo647wGIqObOHbv_aOuMoVRhSx_9d6T5vXlWqfEFdFi7NiGmpQZuw9eHW-F1jiKjl_O_LyMWwOTuUTRNN-_jxxOHHDagwMl_aS-WK7u9xaOVfK-QDU21c_eG3rqEW8vEQhefy31U5_VkL8j9gNMhlWTz-lw38OHVSx3EWZDgC07KgN4qD9RwtnwMqeiGiGYVxSbJxopJydKd9Cnx1iq9I104xswrAO9R9vHcTocbR_AvAqeMLwG8acPyNwX1pBDKr2JnD6rqxWpfLEjmzHzXINZZCmwZ94YPsdCJctAvAB1-GWYhIKBuX6bTkqW0NIg9sAAQ9-KGE-HqN4J9ZVwFWfHK2fivSrLbi4_Nq9YwbS6JA9R0sNGHTL2s45npQac27pbQfWxrGeGXlf276LQZKOeE2Y4XmKMCW-UvxPqD8LLWoqK_FUHJNQ9fws1HBQoKF-igXA",
                    "isNew": false
                },
                "code": 200
            }
        }
     */
    public function verify(AuthRequest $request){
        $user = $this->user->findByPhoneNumber($request->phone_number);
        if(!Validation::validate($user->id, $request->code)){
            return $this->customErrorResponse(null, ['کد تایید صحیح نمیباشد'], 401);
        }

        $token = $user->createToken(self::PersonalTokenName)->accessToken;
        $isNew = $user->active ? false: true;

        return $this->successResponse(['token' => $token, 'isNew' => $isNew], null, 200);
    }
}
