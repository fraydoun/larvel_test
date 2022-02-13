<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PublicController
 * @package App\Http\Controllers\Api
 * this controller is for public featurs .
 */
class PublicController extends Controller
{

    /**
     * @api {post} /api/public/states get list all states.
     * @apiGroup Public
     * @apiName states
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
    {
    "data": {
        "status": "success",
        "messages": null,
        "result": [
            {
                "id": 1,
                "state": "آذربایجان شرقی"
            },
            {
                "id": 2,
                "state": "آذربایجان غربی"
            },
            {
                "id": 3,
                "state": "اردبیل"
            },
            {
                "id": 4,
                "state": "اصفهان"
            },
            {
                "id": 5,
                "state": "البرز"
            },
            {
                "id": 6,
                "state": "ایلام"
            },
                ...
            ],
            "code": 200
            }
        }
     */
    public function state(Request $request)
    {
        $states = State::all()->toArray();
        return $this->successResponse($states);
    }


    /**
     * @api {post} /api/public/cities/{state-id} get list cities of one state.
     * @apiGroup Public
     * @apiName cities
     * @apiErrorExample  {json} Error 1: state not found
     * Http/1.1 404 Internal Server Error
        {
            "data": {
            "status": "error",
            "message": [
                "استان مورد نظر یافت نشد"
            ],
            "results": null,
            "code": 404
            }
        }
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
            "status": "success",
            "messages": null,
            "result": [
                {
                "id": 14,
                "name": "آبش احمد",
                "state": 1
                },
                {
                "id": 21,
                "name": "آذرشهر",
                "state": 1
                },
                {
                "id": 39,
                "name": "آقکند",
                "state": 1
                },
                ...
            ],
            "code": 200
            }
        }
     */
    public function city(Request $request, $state_id){
        $state = State::find($state_id);
        if(!$state){
            throw new NotFoundHttpException('استان مورد نظر یافت نشد');
        }

        $cities = City::where('state', $state_id)->get()->toArray();
        return $this->successResponse($cities);
    }


    /**
     * @api {post} /api/public/categories get list categories
     * @apiGroup Public
     * @apiName categories
     * @apiParam {string} category category name in category! (optional) => default : ads
     * @apiSuccessExample Success-Response:
     *  HTTP/1.1 200 OK
        {
            "data": {
                "status": "success",
                "messages": null,
                "result": [
                    {
                        "id": 1,
                        "title": "املاک",
                        "parent": null,
                        "icon": null,
                        "created_at": "2022-01-08T19:36:13.000000Z",
                        "updated_at": "2022-01-08T19:36:13.000000Z",
                        "rel_childs": [
                            {
                                "id": 2,
                                "title": "ویلایی",
                                "parent": 1,
                                "icon": null,
                                "category": "ads",
                                "created_at": null,
                                "updated_at": null
                            }
                        ]
                    }
                ],
                "code": 200
            }
        }
     */
    public function categories(Request $request){
        $category = $request->category ?? 'ads'; // if not send category for category default is ads.
        
        $cats = Category::where('category', $category)->where('parent', null)->with('relChilds')->get()->makeHidden('category');

        return $this->successResponse($cats);
    }
}
