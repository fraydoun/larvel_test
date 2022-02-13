<?php

namespace App\Http\Controllers\Api\V1\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\ads\CreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    /**
     * @api {get} /v1/ads/category/{category_id}/create دریافت لیست فرم برای ایجاد اگهی
     * @apiGroup Ads
     * @apiName getFormItem
     * @apiParam {integer} category_id ایدی دسته بندی مورد نظر (required)
     * @apiHeader  {String} Authorization توکن احراز هویت . (Bearer Token)
     * @apiHeaderExample {json} Header-Example:
        {
            "Authorization": "Bearer {TOKEN}"
        }
     *
     *
     * @apiErrorExample {json} Error parameters: Data not Found.
     *  HTTP/1.1 404 Not Found
        {
            "data": {
                "status": "error",
                "messages": [
                    "داده مورد نظر در دیتابیس یافت نشد"
                ],
                "result": null,
                "code": 404
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
                "result": [
                    {
                        "id": 1,
                        "title": "عنوان را وارد کنید",
                        "slug": "title",
                        "type_field": "text",
                        "price": null,
                        "settings": {
                            "min": 10,
                            "max": 100,
                            "direction": "rtl",
                            "placeHolder": "this is hint",
                            "required": true,
                            "style": null,
                            "class": null,
                            "value": null
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "title"
                    },
                    {
                        "id": 2,
                        "title": "سن را وارد کنید",
                        "slug": "age",
                        "type_field": "number",
                        "price": null,
                        "settings": {
                            "min": 10,
                            "max": 100,
                            "placeHolder": "this is hint",
                            "direction": "ltr",
                            "required": true,
                            "style": null,
                            "class": null,
                            "value": null
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "age"
                    },
                    {
                        "id": 3,
                        "title": "جنسیت را انتخاب کنید",
                        "slug": "gender",
                        "type_field": "one_select",
                        "price": null,
                        "settings": {
                            "options": {
                                "male": "مذکر",
                                "famle": "مونث",
                                "other": "غیره"
                            },
                            "placeHolder": "this is hint",
                            "direction": "rtl",
                            "required": false,
                            "style": null,
                            "class": null,
                            "value": null
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "gender"
                    },
                    {
                        "id": 4,
                        "title": "ویژگی های اضافه را انتخاب کنید",
                        "slug": "features",
                        "type_field": "multi_select",
                        "price": null,
                        "settings": {
                            "options": {
                                "room": "اتاق اضافه",
                                "yard": "حیاط",
                                "parking": "پارکینگ",
                                "garden": "باغچه"
                            },
                            "placeHolder": "this is hint",
                            "direction": "rtl",
                            "required": true,
                            "style": null,
                            "class": null,
                            "value": null
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "features"
                    },
                    {
                        "id": 5,
                        "title": "توضیحات را وارد کنید",
                        "slug": "description",
                        "type_field": "textarea",
                        "price": null,
                        "settings": {
                            "direction": "rtl",
                            "cols": 6,
                            "placeHolder": "this is hint",
                            "required": true,
                            "style": null,
                            "class": null,
                            "value": null,
                            "min" => 20,
                            "max" => 500,
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "description"
                    },
                    {
                        "id": 6,
                        "title": "نشان فوری (۱۰۰۰ تومان)",
                        "slug": "force_label",
                        "type_field": "bool",
                        "price": 1000,
                        "settings": {
                            "style": null,
                            "class": null,
                            "value": true
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "force_label"
                    },
                    {
                        "id": 7,
                        "title": "یکی از موارد زیر را انتخاب کنید",
                        "slug": "selct_one",
                        "type_field": "radio_group",
                        "price": null,
                        "settings": {
                            "type_show": "horizontal",
                            "options": {
                                "personal": "شخصی",
                                "business": "کسب کار"
                            },
                            "style": null,
                            "class": null,
                            "value": null
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "selct_one"
                    },
                    {
                        "id": 8,
                        "title": "یک از موارد زیر را انتخاب کنید",
                        "slug": "select_one2",
                        "type_field": "radio_group",
                        "price": null,
                        "settings": {
                            "type_show": "vertical",
                            "options": {
                                "personal": "شخصی",
                                "business": "کسب کار"
                            }
                        },
                        "created_at": "2022-01-11T21:29:31.000000Z",
                        "updated_at": "2022-01-11T21:29:31.000000Z",
                        "name": "select_one2"
                    }
                ],
                "code": 200
            }
        }
     */
    public function itemForm(Request $request, Category $category){
        $form = $category->relForm;
        return $this->successResponse($form);
    }


    public function create(CreateRequest $request){
        
    }
}
