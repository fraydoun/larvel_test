define({ "api": [
  {
    "type": "get",
    "url": "/v1/ads/category/{category_id}/create",
    "title": "دریافت لیست فرم برای ایجاد اگهی",
    "group": "Ads",
    "name": "getFormItem",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "category_id",
            "description": "<p>ایدی دسته بندی مورد نظر (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: Data not Found.",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"داده مورد نظر در دیتابیس یافت نشد\"\n               ],\n               \"result\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 1,\n                       \"title\": \"عنوان را وارد کنید\",\n                       \"slug\": \"title\",\n                       \"type_field\": \"text\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"min\": 10,\n                           \"max\": 100,\n                           \"direction\": \"rtl\",\n                           \"placeHolder\": \"this is hint\",\n                           \"required\": true,\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"title\"\n                   },\n                   {\n                       \"id\": 2,\n                       \"title\": \"سن را وارد کنید\",\n                       \"slug\": \"age\",\n                       \"type_field\": \"number\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"min\": 10,\n                           \"max\": 100,\n                           \"placeHolder\": \"this is hint\",\n                           \"direction\": \"ltr\",\n                           \"required\": true,\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"age\"\n                   },\n                   {\n                       \"id\": 3,\n                       \"title\": \"جنسیت را انتخاب کنید\",\n                       \"slug\": \"gender\",\n                       \"type_field\": \"one_select\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"options\": {\n                               \"male\": \"مذکر\",\n                               \"famle\": \"مونث\",\n                               \"other\": \"غیره\"\n                           },\n                           \"placeHolder\": \"this is hint\",\n                           \"direction\": \"rtl\",\n                           \"required\": false,\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"gender\"\n                   },\n                   {\n                       \"id\": 4,\n                       \"title\": \"ویژگی های اضافه را انتخاب کنید\",\n                       \"slug\": \"features\",\n                       \"type_field\": \"multi_select\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"options\": {\n                               \"room\": \"اتاق اضافه\",\n                               \"yard\": \"حیاط\",\n                               \"parking\": \"پارکینگ\",\n                               \"garden\": \"باغچه\"\n                           },\n                           \"placeHolder\": \"this is hint\",\n                           \"direction\": \"rtl\",\n                           \"required\": true,\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"features\"\n                   },\n                   {\n                       \"id\": 5,\n                       \"title\": \"توضیحات را وارد کنید\",\n                       \"slug\": \"description\",\n                       \"type_field\": \"textarea\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"direction\": \"rtl\",\n                           \"cols\": 6,\n                           \"placeHolder\": \"this is hint\",\n                           \"required\": true,\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null,\n                           \"min\" => 20,\n                           \"max\" => 500,\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"description\"\n                   },\n                   {\n                       \"id\": 6,\n                       \"title\": \"نشان فوری (۱۰۰۰ تومان)\",\n                       \"slug\": \"force_label\",\n                       \"type_field\": \"bool\",\n                       \"price\": 1000,\n                       \"settings\": {\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": true\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"force_label\"\n                   },\n                   {\n                       \"id\": 7,\n                       \"title\": \"یکی از موارد زیر را انتخاب کنید\",\n                       \"slug\": \"selct_one\",\n                       \"type_field\": \"radio_group\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"type_show\": \"horizontal\",\n                           \"options\": {\n                               \"personal\": \"شخصی\",\n                               \"business\": \"کسب کار\"\n                           },\n                           \"style\": null,\n                           \"class\": null,\n                           \"value\": null\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"selct_one\"\n                   },\n                   {\n                       \"id\": 8,\n                       \"title\": \"یک از موارد زیر را انتخاب کنید\",\n                       \"slug\": \"select_one2\",\n                       \"type_field\": \"radio_group\",\n                       \"price\": null,\n                       \"settings\": {\n                           \"type_show\": \"vertical\",\n                           \"options\": {\n                               \"personal\": \"شخصی\",\n                               \"business\": \"کسب کار\"\n                           }\n                       },\n                       \"created_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"updated_at\": \"2022-01-11T21:29:31.000000Z\",\n                       \"name\": \"select_one2\"\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/Ads/AdsController.php",
    "groupTitle": "Ads"
  },
  {
    "type": "post",
    "url": "/api/auth",
    "title": "login and recive sms code",
    "name": "auth",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "phone_number",
            "description": "<p>client for recive code.</p>"
          }
        ]
      }
    },
    "error": {
      "examples": [
        {
          "title": "Error1: phone_number required.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"شماره تلفن الزامی میباشد\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error2: length must 11 charecter",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n   \"طول شماره تلفن باید 11 کارکتر باشد\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error3: phone_number is not correct",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n   \"شماره تلفن بصورت صحیح وارد نشده است\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error4: Too many Request for send code",
          "content": "HTTP/1.1 429 Too Many Request\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n               \"درخواست بعدی برای دریافت کد در 118 ثانیه بعد\"\n               ],\n               \"result\": null,\n               \"code\": 429\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"code\": 2057\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Auth/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/verify",
    "title": "verify phone_number via sms code.",
    "name": "verify",
    "group": "Auth",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "phone_number",
            "description": "<p>client for recive code.</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "code",
            "description": "<p>activate code that send sms client</p>"
          }
        ]
      }
    },
    "error": {
      "examples": [
        {
          "title": "Error1: phone_number required.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n   {\n       \"data\": {\n           \"status\": \"error\",\n           \"messages\": [\n               \"شماره تلفن الزامی میباشد\"\n           ],\n           \"result\": null,\n           \"code\": 422\n       }\n   }",
          "type": "json"
        },
        {
          "title": "Error2: code is required",
          "content": "HTTP/1.1 422 Unprocessable Entity\n   {\n       \"data\": {\n           \"status\": \"error\",\n           \"messages\": [\n               \"کد تایید الزامی است\"\n           ],\n           \"result\": null,\n           \"code\": 422\n       }\n   }",
          "type": "json"
        },
        {
          "title": "Error3: code is required",
          "content": "HTTP/1.1 401 Unauthorized\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"کد تایید صحیح نمیباشد\"\n               ],\n               \"result\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n                   \"status\": \"success\",\n                   \"messages\": null,\n                   \"result\": {\n                   \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGFhN2MwNDZhMjgwZTE4MzI5ZmZhM2RjYTZmYmZlYzU2ZGU1MWU0OWIxNDY5MzIzNjdjM2FjN2I0MWY4MjFhNGExODM2NmFiNGIxMGE5MjQiLCJpYXQiOjE2Mjg1NDA1NTguOTg1MTEwMDQ0NDc5MzcwMTE3MTg3NSwibmJmIjoxNjI4NTQwNTU4Ljk4NTExNzkxMjI5MjQ4MDQ2ODc1LCJleHAiOjE2NjAwNzY1NTguOTc2OTM4MDA5MjYyMDg0OTYwOTM3NSwic3ViIjoiMSIsInNjb3BlcyI6W119.HICu1lq-aMHC7MnY7pjz3m8jNJ32S4RzrHNYyNqPPxcFqxFTG3YUscmKMTRCi0nftxLsTCZ8noQreoj4OnFOr-q8CIE2TIyW9JRz0lHcXUqEH1jyykmYDRPz9DtAcr2WWRZOI1D2fwDImr38rNJfYiPe32BynvGntwwRMKHQgT_T3Xj_uP9L9l48pKQCRAXd0Gt0MQpTIt0K-N4w3LFhZkSiis-W0WbOa1wogWo647wGIqObOHbv_aOuMoVRhSx_9d6T5vXlWqfEFdFi7NiGmpQZuw9eHW-F1jiKjl_O_LyMWwOTuUTRNN-_jxxOHHDagwMl_aS-WK7u9xaOVfK-QDU21c_eG3rqEW8vEQhefy31U5_VkL8j9gNMhlWTz-lw38OHVSx3EWZDgC07KgN4qD9RwtnwMqeiGiGYVxSbJxopJydKd9Cnx1iq9I104xswrAO9R9vHcTocbR_AvAqeMLwG8acPyNwX1pBDKr2JnD6rqxWpfLEjmzHzXINZZCmwZ94YPsdCJctAvAB1-GWYhIKBuX6bTkqW0NIg9sAAQ9-KGE-HqN4J9ZVwFWfHK2fivSrLbi4_Nq9YwbS6JA9R0sNGHTL2s45npQac27pbQfWxrGeGXlf276LQZKOeE2Y4XmKMCW-UvxPqD8LLWoqK_FUHJNQ9fws1HBQoKF-igXA\",\n                   \"isNew\": false\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/Auth/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/api/v1/building/change-manager",
    "title": "تغییر مدیر یک ساختمان",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "buildin_id",
            "description": "<p>id of building  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_number_new_manager",
            "description": "<p>phone number new manager (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sheba",
            "description": "<p>sheba  bank new manager. (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "card_number",
            "description": "<p>bank card number new manager (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name_owner_bank",
            "description": "<p>name owner bank new manager (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name_owner_bank",
            "description": "<p>last name owner bank new manager(optional)</p>"
          }
        ]
      }
    },
    "group": "Building",
    "name": "Change_Manger",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Not found;",
          "content": "HTTP/1.1 404 Not Found!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Access Deny;",
          "content": "HTTP/1.1 403 Access Deny!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"شما به این بخش دسترسی نداری\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی ساختمان الزامی میباشد\",\n                   \"شماره تلفن مدیر جدید الزامی میباشد\",\n                   \"شماره شبا 24 کرکتر است\",\n                   \"شماره کارت 16 کرکتر است\",\n                   \"شماره حساب ۱۰ کرکتر است\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\"عملیات با موفقیت انجام شد\"],\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/create",
    "title": "ایجاد یک ساختمان جدید.",
    "group": "Building",
    "name": "Create",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>نام ساختمان (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sheba",
            "description": "<p>شماره شبای حساب ساختمان. (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "card_number",
            "description": "<p>شماره کارت حساب ساختمان (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_number",
            "description": "<p>شماره حساب بانکی ساختمان(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name_owner_bank",
            "description": "<p>نام صاحب حساب بانکی ساختمان.(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name_owner_bank",
            "description": "<p>نام خانوادگی حساب بانکی ساختمان.(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit",
            "description": "<p>تعداد واحد های ساختمان(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "floor",
            "description": "<p>تعداد طبقات ساختمان (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>آدرس (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "state",
            "description": "<p>ایدی استان  (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city",
            "description": "<p>ایدی شهر (optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"نام ساختمان الزامی است \",\n                   \"شماره شبا الزامی است\",\n                   \"شماره کارت الزامی است\",\n                   \"شماره حساب الزامی است\",\n                   \"نام صاحب حساب الزامی است\",\n                   \"نام خانوادگی صاحب حساب الزامی است\",\n                   'فرمت های قابل قبول jpeg, png, jpg',\n                   ,'حجم عکس نباید بیش از 5 مگابایت باشد'\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: To Many Request",
          "content": "Http/1.1 429 To Many Request.\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                \"در هر دقیقه میتوانید یک درخواست ارسال کنید\"\n                ],\n                \"results\": null,\n                \"code\": 429\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Error 4: Internal server Error",
          "content": "Http/1.1 500 Internal Server Error\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"مشکلی در ایجاد ساختمان پیش امده .لطفا مجدد امتحان کنید\"\n                ],\n                \"results\": null,\n                \"code\": 500\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"building_id\": 5,\n                   \"code\": \"b9721195\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/full-info/{building_id}",
    "title": "اطلاعات کامل یک ساختمان",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "buildin_id",
            "description": "<p>id of building  (required) بجای {building_id} قرار میگیرد</p>"
          }
        ]
      }
    },
    "group": "Building",
    "name": "Full_info",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Not found;",
          "content": "HTTP/1.1 404 Not Found!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Access Deny;",
          "content": "HTTP/1.1 403 Access Deny!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"شما به این ساختمان دسترسی ندارید\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"id\": 1,\n                   \"name\": \"testdd\",\n                   \"unit\": 30,\n                   \"floor\": 6,\n                   \"manager\": 1,\n                   \"wallet\": 50000,\n                   \"cash_desk\": 0,\n                   \"state\": 1,\n                   \"city\": 3,\n                   \"address\": \"mahhad blv avini\",\n                   \"sheba\": \"789456123012365478954587\",\n                   \"card_number\": \"1234567891234567\",\n                   \"bank_number\": \"1234567891\",\n                   \"name_owner_bank\": \"abbass\",\n                   \"last_name_owner_bank\": \"jafari\",\n                   \"code\": \"b781\",\n                   \"image\": null,\n                   \"created_at\": \"2021-10-02T20:29:38.000000Z\",\n                   \"updated_at\": \"2021-10-02T20:37:26.000000Z\",\n                   \"my_role\": \"manager\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/join",
    "title": "ورود به یک ساختمان یا واحد.",
    "group": "Building",
    "name": "Join",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>کد واحد یا ساختمان (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"کد واحد یا ساختمان الزامی میباشد\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Forbidden : access denied errors",
          "content": "HTTP/1.1 403 Forbidden\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"شما قبلا در این ساختمان وارد شده اید\",\n                   \"این واحد دارای ساکن فعال میباشد و نمیتوان وارد ان شد\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n           \"status\": \"error\",\n           \"message\": [\n               \"احراز هویت نشده اید\"\n           ],\n           \"results\": null,\n           \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"building\": {\n                       \"id\": 2,\n                       \"name\": \"testdd\",\n                       \"unit\": null,\n                       \"floor\": null,\n                       \"manager\": 1,\n                       \"wallet\": 0,\n                       \"sheba\": \"789456123012365478954587\",\n                       \"card_number\": \"1234567891234567\",\n                       \"bank_number\": \"1234567891\",\n                       \"name_owner_bank\": \"abbass\",\n                       \"last_name_owner_bank\": \"jafari\",\n                       \"code\": \"b752\",\n                       \"created_at\": \"2021-08-20T08:22:55.000000Z\",\n                       \"updated_at\": \"2021-08-20T08:22:55.000000Z\"\n                   },\n                   \"type\": \"building\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"unit\": {\n                       \"id\": 2,\n                       \"name\": \"testdd\",\n                       \"unit\": null,\n                       \"floor\": null,\n                       \"manager\": 1,\n                       \"wallet\": 0,\n                       \"sheba\": \"789456123012365478954587\",\n                       \"card_number\": \"1234567891234567\",\n                       \"bank_number\": \"1234567891\",\n                       \"name_owner_bank\": \"abbass\",\n                       \"last_name_owner_bank\": \"jafari\",\n                       \"code\": \"b752\",\n                       \"created_at\": \"2021-08-20T08:22:55.000000Z\",\n                       \"updated_at\": \"2021-08-20T08:22:55.000000Z\"\n                   },\n                   \"type\": \"unit\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/create",
    "title": "ویرایش یک ساختمان",
    "group": "Building",
    "name": "Update",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "building_id",
            "description": "<p>ایدی ساختمان(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>نام ساختمان (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sheba",
            "description": "<p>شماره شبای حساب ساختمان. (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "card_number",
            "description": "<p>شماره کارت حساب ساختمان (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_number",
            "description": "<p>شماره حساب بانکی ساختمان(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name_owner_bank",
            "description": "<p>نام صاحب حساب بانکی ساختمان.(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name_owner_bank",
            "description": "<p>نام خانوادگی حساب بانکی ساختمان.(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit",
            "description": "<p>تعداد واحد های ساختمان(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "floor",
            "description": "<p>تعداد طبقات ساختمان (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>آدرس (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "state",
            "description": "<p>ایدی استان  (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city",
            "description": "<p>ایدی شهر (optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"نام ساختمان الزامی است \",\n                   'فرمت های قابل قبول jpeg, png, jpg',\n                   ,'حجم عکس نباید بیش از 5 مگابایت باشد',\n                   \"شماره شبا 24 کرکتر است\",\n                   \"شماره کارت 16 کرکتر است\",\n                   \"شماره حساب ۱۰ کرکتر است\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: NotFound;",
          "content": "HTTP/1.1 404 Not Found!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Access Deny!;",
          "content": "HTTP/1.1 403 Access Deny!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"شما به این بخش دسترسی ندارید\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\n                   \"ساختمان با موفقیت بروز رسانی شد\"\n               ],\n               \"result\": {\n                   \"id\": 2,\n                   \"name\": \"عباس\",\n                   \"unit\": 11,\n                   \"floor\": 5,\n                   \"manager\": 1,\n                   \"wallet\": 0,\n                   \"name_owner_bank\": \"abbass\",\n                   \"last_name_owner_bank\": \"jafari\",\n                   \"code\": \"b042\",\n                   \"image\": \"/storage/photos/building/image-2.png\",\n                   \"created_at\": \"2021-10-12T16:50:04.000000Z\",\n                   \"updated_at\": \"2021-10-12T17:08:37.000000Z\",\n                   \"deleted_at\": null,\n                   \"my_role\": \"manager\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/delete/{building_id}",
    "title": "حذف یک ساختمان",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "buildin_id",
            "description": "<p>id of building  (required) بجای {building_id}</p>"
          }
        ]
      }
    },
    "group": "Building",
    "name": "delete",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Not found;",
          "content": "HTTP/1.1 404 Not Found!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Access Deny;",
          "content": "HTTP/1.1 403 Access Deny!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"شما به این بخش دسترسی نداری\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\"ساختمان با موفقیت حذف شد\"],\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/list-units/{building_id}",
    "title": "لیست واحد های یک ساختمان",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "buildin_id",
            "description": "<p>id of building  (required) بجای {building_id} قرار میگیرد</p>"
          }
        ]
      }
    },
    "group": "Building",
    "name": "list_units",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Not found;",
          "content": "HTTP/1.1 404 Not Found!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Access Deny;",
          "content": "HTTP/1.1 403 Access Deny!\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"شما به این ساختمان دسترسی ندارید\"\n               ],\n               \"results\": null,\n               \"code\": 403\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"units\": [\n                       {\n                           \"id\": 1,\n                           \"title\": \"test\",\n                           \"building_id\": 7,\n                           \"living_people\": null,\n                           \"count_parkings\": null,\n                           \"number_parking\": null,\n                           \"number_warehouse\": null,\n                           \"number_floor\": null,\n                           \"charge\": 1000,\n                           \"day_charge\": 5,\n                           \"code\": \"u511\",\n                           \"created_at\": \"2021-09-12T16:29:11.000000Z\",\n                           \"updated_at\": \"2021-09-12T16:29:11.000000Z\",\n                           \"debt\": \"50000\",\n                           \"rel_active_resident\": {\n                               \"id\": 2,\n                               \"first_name\": null,\n                               \"last_name\": null,\n                               \"email\": null,\n                               \"national_code\": null,\n                               \"phone_number\": \"09369164185\",\n                               \"avatar\": null,\n                               \"active\": 0,\n                               \"created_at\": \"2021-09-12T16:29:11.000000Z\",\n                               \"updated_at\": \"2021-09-12T16:29:11.000000Z\"\n                           }\n                           \n                       }\n                   ]\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/building/my-building",
    "title": "ساختمان های من",
    "group": "Building",
    "name": "my-building",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n               \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 2,\n                       \"name\": \"testdd\",\n                       \"unit\": null,\n                       \"floor\": null,\n                       \"manager\": 1,\n                       \"wallet\": 0,\n                       \"name_owner_bank\": \"abbass\",\n                       \"last_name_owner_bank\": \"jafari\",\n                       \"code\": \"b752\",\n                       \"created_at\": \"2021-08-20T08:22:55.000000Z\",\n                       \"updated_at\": \"2021-08-20T08:22:55.000000Z\",\n                       \"my_role\": \"manager\",\n                       \"my_unit\": {\n                           \"id\": 1,\n                           \"title\": \"test\",\n                           \"debt\": 0\n                       },\n                       \"rel_manager\": {\n                           \"id\": 1,\n                           \"first_name\": null,\n                           \"last_name\": null,\n                           \"email\": null,\n                           \"email_verified_at\": null,\n                           \"national_code\": null,\n                           \"phone_number\": \"09369164186\",\n                           \"active\": 0,\n                           \"created_at\": \"2021-08-15T19:36:41.000000Z\",\n                           \"updated_at\": \"2021-08-15T19:36:41.000000Z\"\n                       }\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/BuildingController.php",
    "groupTitle": "Building"
  },
  {
    "type": "post",
    "url": "/api/v1/factor/create",
    "title": "ایجاد فاکتور جدید برای ساکنان واحد ها",
    "group": "Factor",
    "name": "Create",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "building_id",
            "description": "<p>ایدی ساختمان (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "units",
            "description": "<p>ایدی واحد ها (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>عنوان فاکتور (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>توضیحات فاکتور (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "price",
            "description": "<p>قیمت فاکتور (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "status",
            "description": "<p>وضعیت فاکتور {optional} default = 1</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "part",
            "description": "<p>مشخص کننده کدوم قسمت (لیستش یک سرویس دیگه داره در قسمت public)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"اید واحد الزامی است\",\n                   \"ایدی واحد های مد نظر را باید بفرستید\",\n                   \"عنوان فاکتور الزامی میباشد\",\n                   \"هزینه فاکتور را باید بفرستید\",\n                   \"حداقل کارکتر های عنوان باید 5 حرف باشد\",\n                   \"حداکثر کارکتر های عنوان باید 150 حرف باشد\",\n                   \"به دلیل عدم وجود ساکن در واحد های مد نظر فاکتوری ایجاد نشده است\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "NotFound: Building NotFound.",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "No Access",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n            \"status\": \"error\",\n            \"messages\": [\n                \"شما به این بخش دسترسی ندارید\"\n            ],\n            \"result\": null,\n            \"code\": 403\n        }",
          "type": "json"
        },
        {
          "title": "Not Found: some units not found.",
          "content": "HTTP/1.1 404 Not Found\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"بعضی از واحد ها در سیستم ثبت نشده است . لطفا بررسی نمایید\"\n                ],\n                \"results\": null,\n                \"code\": 404\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Service Unavailable",
          "content": "HTTP/1.1 503 Service Unavailable\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"مشکل ناشناخته بوجود امده و فاکتور ها ایجاد نشد\"\n                ],\n                \"results\": null,\n                \"code\": 503\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n   {\n       \"data\": {\n           \"status\": \"success\",\n           \"messages\": null,\n           \"result\": [\n               {\n                   \"title\": \"هزینه های اضافی شب جشن\",\n                   \"discription\": \"\",\n                   \"price\": \"50000\",\n                   \"item_id\": 1,\n                   \"item_type\": 1,\n                   \"owner\": 1,\n                   \"type\": 2,\n                   \"creator\": 1,\n                   \"updated_at\": \"2021-09-01T19:31:28.000000Z\",\n                   \"created_at\": \"2021-09-01T19:31:28.000000Z\",\n                   \"id\": 13\n               },\n               {\n                   \"title\": \"هزینه های اضافی شب جشن\",\n                   \"discription\": \"\",\n                   \"price\": \"50000\",\n                   \"item_id\": 2,\n                   \"item_type\": 1,\n                   \"owner\": 1,\n                   \"type\": 2,\n                   \"creator\": 1,\n                   \"updated_at\": \"2021-09-01T19:31:28.000000Z\",\n                   \"created_at\": \"2021-09-01T19:31:28.000000Z\",\n                   \"id\": 13\n               }\n           ],\n           \"code\": 200\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/FactorController.php",
    "groupTitle": "Factor"
  },
  {
    "type": "post",
    "url": "/api/v1/factor/delete",
    "title": "حذف فاکتور",
    "group": "Factor",
    "name": "Delete",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "factor_id",
            "description": "<p>ایدی فاکتور (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی فاکتور الزامی است\",\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Not Found",
          "content": "HTTP/1.1 404 Not Found\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                   \"فاکتور مورد نظر در سیستم یافت نشد\"\n                ],\n                \"results\": null,\n                \"code\": 404\n            }\n        }",
          "type": "json"
        },
        {
          "title": "No Access",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"شما به این بخش دسترسی ندارید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Service Unavailable",
          "content": "HTTP/1.1 503 Service Unavailable\n            {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"فاکتور حذف نشد مجدد امتحان کنید\"\n                ],\n                \"results\": null,\n                \"code\": 503\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\n                   'عملیات با موفقیت انجام شد'\n               ],\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/FactorController.php",
    "groupTitle": "Factor"
  },
  {
    "type": "post",
    "url": "/api/v1/factor/buy-charge",
    "title": "ثبت فاکتور خرید شارژ",
    "group": "Factor",
    "name": "buyCharge",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>عنوان  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "price",
            "description": "<p>مبلغ شارژ  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>توضیحات (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "json",
            "optional": false,
            "field": "pay_data",
            "description": "<p>اطلاعات پرداخت(optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"عنوان الزامی است\",\n                   \"مبلغ شارژ الزامی است\",\n                   \"اطلاعات پرداختی باید رشته جیسون باشد\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\n                   \"فاکتور خرید شارژ با موفقیت ثبت شد\"\n               ],\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/FactorController.php",
    "groupTitle": "Factor"
  },
  {
    "type": "post",
    "url": "/api/v1/notification/create",
    "title": "ایجاد اطلاعیه برای کاربران یک ساختمان",
    "group": "Notification",
    "name": "Create",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "building_id",
            "description": "<p>ایدی ساختمان (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "users",
            "description": "<p>ایدی کاربران داخل ساختمان . اگر ارسال نشود برای همه اعضا ایجاد میشود (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>عنوان  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "message",
            "description": "<p>متن پیام (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "file",
            "description": "<p>فایل (optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی ساختمان الزامی میباشد\",\n                   \"فرمت ارسالی ایدی کاربر ها درست نمیباشد\",\n                   \"عنوان الزامی میباشد\",\n                   \"متن پیام الزامی میباشد\",\n                   \"حداقل کرکتر های عنوان ۳ کرکتر میباشد\",\n                   \"فرمت های قابل قبول jpeg, png, jpg, zip, rar\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "NotFound: Building NotFound.",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "No Access",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n            \"status\": \"error\",\n            \"messages\": [\n                \"شما به این بخش دسترسی ندارید\"\n            ],\n            \"result\": null,\n            \"code\": 403\n        }",
          "type": "json"
        },
        {
          "title": "Not Found: users not in building",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"بعضی از کاربر ها در این ساختمان نیستند لطفا لیست کاربر هارا تصحیح کنید\"\n                ],\n                \"results\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Service Unavailable",
          "content": "HTTP/1.1 503 Service Unavailable\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"اطلاعیه ایجاد نشد مجدد امتحان کنید\"\n                ],\n                \"results\": null,\n                \"code\": 503\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": \"اطلاعیه با موفقیت ایجاد شد\",\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/NotifController.php",
    "groupTitle": "Notification"
  },
  {
    "type": "post",
    "url": "/api/v1/notification/info",
    "title": "اطلاعات کامل یک اطلاعیه",
    "group": "Notification",
    "name": "info",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "notif_id",
            "description": "<p>ایدی ساختمان (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی اطلاعیه الزامی میباشد\",\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "NotFound: notification NotFound.",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"اطلاعیه مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "No Access",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n            \"status\": \"error\",\n            \"messages\": [\n                \"شما به این بخش دسترسی ندارید\"\n            ],\n            \"result\": null,\n            \"code\": 403\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"id\": 13,\n                   \"receiver\": 1,\n                   \"title\": \"ارسال اطلاعیه تست\",\n                   \"message\": \"این یک اطلاعیه تستی است که میخواهیم تست بکنیم\",\n                   \"file\": null,\n                   \"action\": null,\n                   \"seen\": 1,\n                   \"created_at\": null,\n                   \"updated_at\": \"2021-10-01T20:21:51.000000Z\",\n                   \"senderInfo\": {\n                       \"id\": 1,\n                       \"fullName\": \"عباس جعفری\"\n                   }\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/NotifController.php",
    "groupTitle": "Notification"
  },
  {
    "type": "post",
    "url": "/api/v1/notification/list",
    "title": "دریافت لیست همه اطلاعیه های کاربر",
    "group": "Notification",
    "name": "list",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"current_page\": 1,\n                   \"data\": [\n                       {\n                           \"id\": 3,\n                           \"title\": \"پرداخت نقدی فاکتور\",\n                           \"message\": \" فاکتور با عنوان *خرید کی\",\n                           \"senderInfo\": {\n                               \"id\": 0,\n                               \"fullName\": \"سیستمی\"\n                           }\n                       },\n                       {\n                           \"id\": 12,\n                           \"title\": \"ارسال اطلاعیه تست\",\n                           \"message\": \" فاکتور با عنوان *خرید کی\",\n                           \"senderInfo\": {\n                               \"id\": 0,\n                               \"fullName\": \"سیستمی\"\n                           }\n                       }\n                   ],\n                   \"first_page_url\": \"http://blog.test/api/v1/notification/list?page=1\",\n                   \"from\": 1,\n                   \"last_page\": 2,\n                   \"last_page_url\": \"http://blog.test/api/v1/notification/list?page=2\",\n                   \"links\": [\n                       {\n                           \"url\": null,\n                           \"label\": \"&laquo; Previous\",\n                           \"active\": false\n                       },\n                       {\n                           \"url\": \"http://blog.test/api/v1/notification/list?page=1\",\n                           \"label\": \"1\",\n                           \"active\": true\n                       },\n                       {\n                           \"url\": \"http://blog.test/api/v1/notification/list?page=2\",\n                           \"label\": \"2\",\n                           \"active\": false\n                       },\n                       {\n                           \"url\": \"http://blog.test/api/v1/notification/list?page=2\",\n                           \"label\": \"Next &raquo;\",\n                           \"active\": false\n                       }\n                   ],\n                   \"next_page_url\": \"http://blog.test/api/v1/notification/list?page=2\",\n                   \"path\": \"http://blog.test/api/v1/notification/list\",\n                   \"per_page\": 10,\n                   \"prev_page_url\": null,\n                   \"to\": 10,\n                   \"total\": 18\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/NotifController.php",
    "groupTitle": "Notification"
  },
  {
    "type": "post",
    "url": "/api/v1/payment/list-payment-manual",
    "title": "لیست پرداختی هایی که منتظر تایید مدیر هستند",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "building_id",
            "description": "<p>ایدی ساختمان (requrired)</p>"
          }
        ]
      }
    },
    "group": "Payment",
    "name": "List_Payment_Manual",
    "description": "<p>لیست همه درخواستی هایی که برای پرداخت نقدی توسط کاربران یک ساختمان ثبت شده است</p> <p>به اینصورت که کاربر یک یا چند فاکتور را انتخاب میکند که برای پرداخت دستی (نقدی) ثبت کند</p> <p>این فاکتور ها همه در قالب یک پرداختی در سرور ثبت میشود</p> <p>پس هر پرداختی شامل تعدادی فاکتور ،اطلاعات پرداختی و وضعیت میباشد</p> <p>کد وضعیت ها که هم برای فاکتور ها و هم برای درخواست پرداختی ها یکسان میباشد شامل:</p> <p>1 :  منتظر پرداخت</p> <p>2 : پرداخت شده</p> <p>3 :  منتظر تایید مدیر</p> <p>4 : رد شده توسط مدیر</p> <p>در این سرویس فقط لیست پرداختی هایی داده میشود که کد وضعیت آنها 3 باشد</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                  \"ایدی ساختمان الزامی میباشد\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "building Not Found",
          "content": "HTTP/1.1 404 NotFound!\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"ساختمان مورد نظر یافت نشد\"\n                ],\n                \"result\": null,\n                \"code\": 404\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Access Denied",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"شما دسترسی لازم برای عملیات در این بخش را ندارید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: return url payment",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 8,\n                       \"type_bank\": 0,\n                       \"pay_data\": {\n                           \"description\": \"this is test for test\",\n                           \"document\": [\n                               \"/storage/photos/payment/document-8.png\"\n                           ]\n                       },\n                       \"payer\": 2,\n                       \"status\": 3,\n                       \"created_at\": \"2021-10-05T09:40:53.000000Z\",\n                       \"updated_at\": \"2021-10-05T09:40:53.000000Z\",\n                       \"status_label\": \"منتظر تایید مدیر\",\n                       \"rel_payer\": {\n                           \"id\": 2,\n                           \"first_name\": \"عباس\",\n                           \"last_name\": \"جعفری\",\n                           \"fullName\": \"عباس جعفری\"\n                       },\n                       \"rel_factors\": [\n                           {\n                               \"id\": 1,\n                               \"title\": \"هزینه های اضافی شب جشن\",\n                               \"description\": \"خرید کیک و شیرینی و تنقلات اضافه\",\n                               \"owner\": 2,\n                               \"creator\": 1,\n                               \"price\": 50000,\n                               \"type\": 2,\n                               \"status\": 3,\n                               \"item_type\": 1,\n                               \"item_id\": 1,\n                               \"count\": 1,\n                               \"part\": {\n                                   \"id\": 1,\n                                   \"title\": \"تعمیرات\"\n                               },\n                               \"payment_deadline\": null,\n                               \"created_at\": \"2021-10-02T20:30:30.000000Z\",\n                               \"updated_at\": \"2021-10-07T10:43:09.000000Z\"\n                           },\n                           {\n                               \"id\": 2,\n                               \"title\": \"هزینه های اضافی شب جشن\",\n                               \"description\": \"خرید کیک و شیرینی و تنقلات اضافه\",\n                               \"owner\": 2,\n                               \"creator\": 1,\n                               \"price\": 50000,\n                               \"type\": 2,\n                               \"status\": 1,\n                               \"item_type\": 1,\n                               \"item_id\": 1,\n                               \"count\": 1,\n                               \"part\": {\n                                   \"id\": 1,\n                                   \"title\": \"تعمیرات\"\n                               },\n                               \"payment_deadline\": null,\n                               \"created_at\": \"2021-10-02T20:30:37.000000Z\",\n                               \"updated_at\": \"2021-10-05T20:34:53.000000Z\"\n                           }\n                       ]\n                   },\n                   {\n                       \"id\": 9,\n                       \"type_bank\": 0,\n                       \"pay_data\": {\n                           \"description\": \"this is test for test\",\n                           \"document\": [\n                               \"/storage/photos/payment/document-9.png\"\n                           ]\n                       },\n                       \"payer\": 2,\n                       \"status\": 3,\n                       \"created_at\": \"2021-10-07T10:43:09.000000Z\",\n                       \"updated_at\": \"2021-10-07T10:43:09.000000Z\",\n                       \"status_label\": \"منتظر تایید مدیر\",\n                       \"rel_payer\": {\n                           \"id\": 2,\n                           \"first_name\": \"عباس\",\n                           \"last_name\": \"جعفری\",\n                           \"fullName\": \"عباس جعفری\"\n                       },\n                       \"rel_factors\": [\n                           {\n                               \"id\": 1,\n                               \"title\": \"هزینه های اضافی شب جشن\",\n                               \"description\": \"خرید کیک و شیرینی و تنقلات اضافه\",\n                               \"owner\": 2,\n                               \"creator\": 1,\n                               \"price\": 50000,\n                               \"type\": 2,\n                               \"status\": 3,\n                               \"item_type\": 1,\n                               \"item_id\": 1,\n                               \"count\": 1,\n                               \"part\": {\n                                   \"id\": 1,\n                                   \"title\": \"تعمیرات\"\n                               },\n                               \"payment_deadline\": null,\n                               \"created_at\": \"2021-10-02T20:30:30.000000Z\",\n                               \"updated_at\": \"2021-10-07T10:43:09.000000Z\"\n                           }\n                       ]\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/api/v1/payment/manual-payment",
    "title": "پرداخت نقدی فاکتور",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد کاربر (requrired)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "factor_ids",
            "description": "<p>لیست ایدی های فاکتور هایی که قرار است پرداخت شود (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>توضیحات از سمت کاربر برای پرداخت نقدی (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "document",
            "description": "<p>سندی که مشخص میکند پرداخت نقدی هست این سند عکس میباشد(optional)</p>"
          }
        ]
      }
    },
    "group": "Payment",
    "name": "Manual_Payment",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی واحد الزامی میباشد\",\n                   \"فرمت ارسالی فاکتور ها صحیح نمیباشد\",\n                   \"فاکتوری برای پرداخت باید انتخاب شود\",\n                   \"عکس باید یک فایل باشد\",\n                   \"فرمت های قابل قبول jpeg, png, jpg\",\n                   \"\",\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Access Denied",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Service Unavilable",
          "content": "HTTP/1.1 503 Unavilable\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"خطایی اتفاق افتاده لطفا مجدد امتحان کنید\"\n                ],\n                \"result\": null,\n                \"code\": 503\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: return url payment",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": 'درخواست با موفقیت ثبت شد و پس از تایید مدیر پرداخت  تکمیل میشود',\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/api/v1/payment/manual-payment-confirmation",
    "title": "تایید یا رد یک پرداختی که کاربر از طریق نقدی زده است",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد که پرداختی در ان صورت گرفته (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "payment_id",
            "description": "<p>ایدی پرداختی (requrired)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "confirmation",
            "description": "<p>وضعیت پرداختی (required) if == 0 reject and == 1 accept</p>"
          }
        ]
      }
    },
    "group": "Payment",
    "name": "Manual_payment_confrimation",
    "description": "<p>بعد اینکه کاربر پرداخت دستی یا همان نقدی را زد نوتیفیکیشنی برای مدیر ارسال میشود با مضمون اینکه کاربر فلان فاکتور هارا</p> <p>نقدی پرداخت کرده است در صورتی که میخواهید تایید کنید به بخش پرداختی ها بروید</p> <p>بعد اینکه مدیر به بخش پرداختی ها میرود و لیست پرداختی هایی که بصورت نقدی پرداخت شده و هنوز تایید نشده را میبیند</p> <p>میتواند هر کدام را تایید کند که باید درخواست تایید ان را به این سرویس ارسال کنید</p> <p>پارامتر confirmation شامل مقدار:</p> <p>0: رد شده</p> <p>1: تایید شده</p> <p>میباشد.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی واحد الزامی میباشد\",\n                   \"ایدی پرداخت الزامی میباشد\",\n                   \"کد تایید الزامی میباشد\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "building Not Found",
          "content": "HTTP/1.1 404 NotFound!",
          "type": "json"
        },
        {
          "title": "Access Denied",
          "content": "        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"واحد مورد نظر یافت نشد\",\n                    \"پرداختی با این ایدی یافت نشد\"\n                ],\n                \"result\": null,\n                \"code\": 404\n            }\n        }\nHTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"شما دسترسی لازم برای عملیات در این بخش را ندارید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: return url payment",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": \"عملیات با موفقیت انجام شد\",\n               \"result\": null\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/api/v1/payment/request",
    "title": "درخواست برای پرداخت اینترنت فاکتور ها",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "gate_id",
            "description": "<p>ایدی درگاهی که قرار است پرداخت شود (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "factor_ids",
            "description": "<p>لیست ایدی های فاکتور هایی که قرار است پرداخت شود (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "device",
            "description": "<p>یکی از مقادیر (android, web, ios)</p>"
          }
        ]
      }
    },
    "group": "Payment",
    "name": "Request",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی درگاه پرداخت الزامی میباشد\",\n                   \"فرمت ارسالی فاکتور ها صحیح نمیباشد\",\n                   \"فاکتوری برای پرداخت باید انتخاب شود\",\n                   \"نوع دیوایس باید مشخص شود (web, android, ios)\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Access Denied",
          "content": "HTTP/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"بعضی از فاکتور ها برای شما نیست یا قبلا پرداخت شده است لطفا فاکتور های پرداخت نشده را انتخاب کنید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Service Unavilable",
          "content": "HTTP/1.1 503 Unavilable\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"message\": [\n                    \"خطایی اتفاق افتاده لطفا مجدد امتحان کنید\"\n                ],\n                \"result\": null,\n                \"code\": 503\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: return url payment",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"url\": \"http://blog.test/payment/start-pay/jRfnM\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/api/v1/payment/list-gates",
    "title": "لیست درگاه های پرداخت",
    "group": "Payment",
    "name": "list_Gates",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 1,\n                       \"name\": \"zarinPal\",\n                       \"title\": \"ذرین پال\",\n                       \"icon\": \"\"\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/api/public/categories",
    "title": "get list categories",
    "group": "Public",
    "name": "categories",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "category",
            "description": "<p>category name in category! (optional) =&gt; default : ads</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 1,\n                       \"title\": \"املاک\",\n                       \"parent\": null,\n                       \"icon\": null,\n                       \"created_at\": \"2022-01-08T19:36:13.000000Z\",\n                       \"updated_at\": \"2022-01-08T19:36:13.000000Z\",\n                       \"rel_childs\": [\n                           {\n                               \"id\": 2,\n                               \"title\": \"ویلایی\",\n                               \"parent\": 1,\n                               \"icon\": null,\n                               \"category\": \"ads\",\n                               \"created_at\": null,\n                               \"updated_at\": null\n                           }\n                       ]\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PublicController.php",
    "groupTitle": "Public"
  },
  {
    "type": "post",
    "url": "/api/public/cities/{state-id}",
    "title": "get list cities of one state.",
    "group": "Public",
    "name": "cities",
    "error": {
      "examples": [
        {
          "title": "Error 1: state not found",
          "content": "Http/1.1 404 Internal Server Error\n        {\n            \"data\": {\n            \"status\": \"error\",\n            \"message\": [\n                \"استان مورد نظر یافت نشد\"\n            ],\n            \"results\": null,\n            \"code\": 404\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n           \"status\": \"success\",\n           \"messages\": null,\n           \"result\": [\n               {\n               \"id\": 14,\n               \"name\": \"آبش احمد\",\n               \"state\": 1\n               },\n               {\n               \"id\": 21,\n               \"name\": \"آذرشهر\",\n               \"state\": 1\n               },\n               {\n               \"id\": 39,\n               \"name\": \"آقکند\",\n               \"state\": 1\n               },\n               ...\n           ],\n           \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PublicController.php",
    "groupTitle": "Public"
  },
  {
    "type": "post",
    "url": "/api/public/factor/list-parts",
    "title": "list parts a factor.",
    "group": "Public",
    "name": "listParts",
    "success": {
      "examples": [
        {
          "title": "Success-Response: code is for building",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": [\n                   {\n                       \"id\": 0,\n                       \"title\": \"شارژ ساختمان\"\n                   },\n                   {\n                       \"id\": 1,\n                       \"title\": \"تعمیرات\"\n                   },\n                   {\n                       \"id\": 2,\n                       \"title\": \"جشن\"\n                   }\n               ],\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/FactorController.php",
    "groupTitle": "Public"
  },
  {
    "type": "post",
    "url": "/api/public/states",
    "title": "get list all states.",
    "group": "Public",
    "name": "states",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n   \"data\": {\n       \"status\": \"success\",\n       \"messages\": null,\n       \"result\": [\n           {\n               \"id\": 1,\n               \"state\": \"آذربایجان شرقی\"\n           },\n           {\n               \"id\": 2,\n               \"state\": \"آذربایجان غربی\"\n           },\n           {\n               \"id\": 3,\n               \"state\": \"اردبیل\"\n           },\n           {\n               \"id\": 4,\n               \"state\": \"اصفهان\"\n           },\n           {\n               \"id\": 5,\n               \"state\": \"البرز\"\n           },\n           {\n               \"id\": 6,\n               \"state\": \"ایلام\"\n           },\n               ...\n           ],\n           \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/PublicController.php",
    "groupTitle": "Public"
  },
  {
    "type": "post",
    "url": "/api/v1/services/bill/url-payment",
    "title": "پرداخت قبوض",
    "group": "Services",
    "name": "bill",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "bill_id",
            "description": "<p>شناسه قبض (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "pay_id",
            "description": "<p>شناسه پرداخت (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"شناسه قبض الزامی میباشد\",\n                   \"شناسه پرداخت الزامی میباشد\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"code\": 1,\n                   \"trans_id\": 413963,\n                   \"url\": \"https://inax.ir/pay.php?tid=413963\",\n                   \"msg\": \"عملیات موفق\",\n                   \"type_en\": \"elec\",\n                   \"type_fa\": \"برق\",\n                   \"amount\": 59800,\n                   \"pay_type\": \"online\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/Services/BillController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/v1/services/internet/packages",
    "title": "لیست بسته های اینترنت",
    "group": "Services",
    "name": "internet_packages",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"MTN\":{\n                       \"credit\":{...},\n                       \"permanent\": {...}\n                   },\n                  \"MCI\":{\n                       \"credit\":{...},\n                       \"permanent\": {...}\n                   },\n                  \"RTL\":{\n                       \"credit\":{...},\n                       \"permanent\": {...}\n                   },\n                  \"SHT\":{\n                       \"credit\":{...},\n                       \"permanent\": {...}\n                   },\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/Services/InternetController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/v1/services/internet/payment-link",
    "title": "لینک پرداخت بسته",
    "group": "Services",
    "name": "internet_payment_link",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>ایدی بسته اینترنت  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>شماره تلفن همراه (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sim_type",
            "description": "<p>(credit, permanent )  (اعتباری - دایمی)نوع سیمکارت (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "operator",
            "description": "<p>(MTN, MCI, RTL, SHT) نام اپراتور(required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "internet_type",
            "description": "<p>(hourly, daily, weekly, monthly, yearly, amazing, TDLTE) (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی بسته الزامی میباشد\",\n                   \"اپراتور الزامی میباشد\",\n                   \"شماره تلفن الزامی میباشد\",\n                   \"نوع بسته اینترنت الزامی میباشد\",\n                   \"نوع سیمکارت باید مشخص شود\",\n                   \"فرمت شماره تلفن صحیح نمیباشد\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": {\n                   \"url\": \"https://inax.ir/pay.php?tid=422572\"\n               },\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/Services/InternetController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/v1/services/charge/topup",
    "title": "خرید شارژ سیمکارت",
    "group": "Services",
    "name": "topup",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "operator",
            "description": "<p>نام اپراتور (MTN, MCI, RTL, SHT) (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "amount",
            "description": "<p>مبلغ شارژ (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_number",
            "description": "<p>شماره تلفن همراه (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "charge_type",
            "description": "<p>(normal, amazing, mnp, )  نوع شارژ (معمولی ، شگفت انگیز)(required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>توکن احراز هویت . (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"یک اپراتو ابتدا مشخص کنید\",\n                   \"مبلغ شارژ باید وارد شود\",\n                   \"شماره تلفنی که میخواهید شارژ بشود را وارد کنید\",\n                   \"نوع شارژ باید ارسال شود\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: 3th aplication errors",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"باتوجه به اعلام اپراتور ایرانسل، شارژ شگفت انگیز  1,000 و 2,000 تومانی ارائه نمی شود.\",\n                   \"امکان شارژ شگفت انگیز همراه اول وجود ندارد\",\n                   \"شماره موبایل 09156017178 با اپراتور ایرانسل تناسب ندارد . لطفا شماره موبایل یا اپراتور را اصلاح نمائید....\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                  \"url\": \"https://inax.ir/pay.php?tid=406780\"\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/Services/ChargeController.php",
    "groupTitle": "Services"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/factors",
    "title": "get full list factors one unit.",
    "group": "Unit",
    "name": "Factors",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n           {\n               \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی واحد الزامی میباشد\",\n               ],\n               \"results\": null,\n                   \"code\": 422\n               }\n           }",
          "type": "json"
        },
        {
          "title": "Error 2: unit not found",
          "content": "HTTP/1.1 404 Not Found\n           {\n           \"data\": {\n           \"status\": \"error\",\n           \"messages\": [\n               \"واحد مورد نظر در سیستم یافت نشد\"\n           ],\n           \"results\": null,\n           \"code\": 404\n           }\n           }",
          "type": "json"
        },
        {
          "title": "Error 3: not access this section.",
          "content": "Http/1.1 403 Forbidden\n            {\n            \"data\": {\n            \"status\": \"error\",\n            \"messages\": [\n            \"شما دسترسی برای این بخش را ندارید\"\n            ],\n            \"result\": null,\n            \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n           {\n               \"data\": {\n                       \"status\": \"success\",\n                       \"messages\": null,\n                       \"result\": {\n                       \"current_page\": 1,\n                       \"data\": [\n                           {\n                               \"id\": 3,\n                               \"title\": \"شارژ  شهریور ماه ۱۴۰۰\",\n                               \"owner\": 1,\n                               \"creator\": 1,\n                               \"price\": 1000,\n                               \"type\": 1,\n                               \"status\": 1,\n                               \"item_type\": 1,\n                               \"item_id\": 1,\n                               \"count\": 1,\n                               \"part\": {\n                                   \"id\": 1,\n                                   \"title\": \"تعمیرات\"\n                               },\n                               \"payment_deadline\": \"2021-09-06 01:40:28\",\n                               \"created_at\": \"2021-08-26T21:10:28.000000Z\",\n                               \"updated_at\": \"2021-08-26T21:10:28.000000Z\"\n                           }\n                       ],\n                       \"first_page_url\": \"http://blog.test/api/v1/unit/factors?page=1\",\n                       \"from\": 1,\n                       \"last_page\": 1,\n                       \"last_page_url\": \"http://blog.test/api/v1/unit/factors?page=1\",\n                       \"links\": [\n                           {\n                               \"url\": null,\n                               \"label\": \"&laquo; Previous\",\n                               \"active\": false\n                           },\n                           {\n                               \"url\": \"http://blog.test/api/v1/unit/factors?page=1\",\n                               \"label\": \"1\",\n                               \"active\": true\n                           },\n                           {\n                               \"url\": null,\n                               \"label\": \"Next &raquo;\",\n                               \"active\": false\n                           }\n                       ],\n                       \"next_page_url\": null,\n                       \"path\": \"http://blog.test/api/v1/unit/factors\",\n                       \"per_page\": 10,\n                       \"prev_page_url\": null,\n                       \"to\": 1,\n                       \"total\": 1\n                   },\n                   \"code\": 200\n               }\n           }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/group-create",
    "title": "create group unit.",
    "group": "Unit",
    "name": "Group_Create",
    "parameter": {
      "examples": [
        {
          "title": "Request-Example:",
          "content": "{\n    \"building_id\":1,\n    \"units\":[\n        {\n            \"title\": \"unit1\",\n            \"charge\":20000,\n            \"day_charge\": 3,\n            \"living_people\": 2,\n            \"count_parkings\":0,\n            \"number_floor\": 3,\n            \"number_warehouse\":0,\n            \"phone_number\": \"\"\n        },\n        {\n            \"title\": \"unit2\",\n            \"charge\":20000,\n            \"day_charge\": 3,\n            \"living_people\": 2,\n            \"count_parkings\":0,\n            \"number_floor\": 3,\n            \"number_warehouse\":0,\n            \"phone_number\":\"09369164186\"\n        },\n        {\n            \"title\": \"unit3\",\n            \"charge\":20000,\n            \"day_charge\": 3,\n            \"living_people\": 2,\n            \"count_parkings\":0,\n            \"number_floor\": 3,\n            \"number_warehouse\":0\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n\"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error 1: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                  \"دیتای ارسالی صحیح نیست لطفا بعد از بررسی اطلاعات ارسالی  مجدد امتحان کنید\"\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: building not Found;",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: You not access;",
          "content": "HTTP/1.1 404 Not Found\n   {\n       \"data\": {\n           \"status\": \"error\",\n           \"messages\": [\n               \"شما برای این بخش دسترسی لازم را ندارید\"\n           ],\n           \"results\": null,\n           \"code\": 403\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n       \"data\": {\n           \"status\": \"success\",\n           \"messages\": null,\n           \"result\": [\n               {\n               \"title\": \"unit1\",\n               \"charge\": 20000,\n               \"day_charge\": 3,\n               \"living_people\": 2,\n               \"count_parkings\": 0,\n               \"number_floor\": 3,\n               \"number_warehouse\": 0,\n               \"building_id\": 1,\n               \"updated_at\": \"2021-09-05T19:15:17.000000Z\",\n               \"created_at\": \"2021-09-05T19:15:17.000000Z\",\n               \"id\": 39,\n               \"code\": \"u1739\"\n               },\n               {\n               \"title\": \"unit3\",\n               \"charge\": 20000,\n               \"day_charge\": 3,\n               \"living_people\": 2,\n               \"count_parkings\": 0,\n               \"number_floor\": 3,\n               \"number_warehouse\": 0,\n               \"building_id\": 1,\n               \"updated_at\": \"2021-09-05T19:15:17.000000Z\",\n               \"created_at\": \"2021-09-05T19:15:17.000000Z\",\n               \"id\": 41,\n               \"code\": \"u1741\"\n               }\n           ],\n           \"code\": 200\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/info",
    "title": "get full info about unit.",
    "group": "Unit",
    "name": "Info",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n               \"ایدی واحد الزامی میباشد\",\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: unit not found",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"واحد مورد نظر در سیستم یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: not access this section.",
          "content": "Http/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"شما دسترسی برای این بخش را ندارید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n   {\n       \"data\": {\n           \"status\": \"success\",\n           \"messages\": null,\n           \"result\": {\n               \"id\": 1,\n               \"title\": \"test\",\n               \"building_id\": 1,\n               \"living_people\": null,\n               \"count_parkings\": null,\n               \"number_parking\": null,\n               \"number_warehouse\": null,\n               \"number_floor\": null,\n               \"charge\": 1000,\n               \"day_charge\": 27,\n               \"code\": \"u841\",\n               \"created_at\": \"2021-08-25T14:26:24.000000Z\",\n               \"updated_at\": \"2021-08-25T14:26:24.000000Z\",\n               \"debt\": \"1000\",\n               \"rel_building\": {\n                   \"id\": 1,\n                   \"name\": \"testdd\",\n                   \"unit\": null,\n                   \"floor\": null,\n                   \"manager\": 1,\n                   \"wallet\": 0,\n                   \"name_owner_bank\": \"abbass\",\n                   \"last_name_owner_bank\": \"jafari\",\n                   \"code\": \"b671\",\n                   \"created_at\": \"2021-08-25T14:26:07.000000Z\",\n                   \"updated_at\": \"2021-08-25T14:26:07.000000Z\"\n               },\n               \"factors\": [\n                   {\n                   \"id\": 3,\n                   \"title\": \"شارژ  شهریور ماه ۱۴۰۰\",\n                   \"owner\": 1,\n                   \"creator\": 1,\n                   \"price\": 1000,\n                   \"type\": 1,\n                   \"status\": 1,\n                   \"item_type\": 1,\n                   \"item_id\": 1,\n                   \"count\": 1,\n                   \"part\": {\n                       \"id\": 1,\n                       \"title\": \"تعمیرات\"\n                   },\n                   \"payment_deadline\": \"2021-09-06 01:40:28\",\n                   \"created_at\": \"2021-08-26T21:10:28.000000Z\",\n                   \"updated_at\": \"2021-08-26T21:10:28.000000Z\"\n                   }\n               ],\n               \n           },\n           \"code\": 200\n       }\n   }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/remove/{unit_id}",
    "title": "Remove an Unit.",
    "group": "Unit",
    "name": "Remove",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n           {\n               \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی واحد الزامی میباشد\",\n               ],\n               \"results\": null,\n                   \"code\": 422\n               }\n           }",
          "type": "json"
        },
        {
          "title": "Error 2: unit not found",
          "content": "HTTP/1.1 404 Not Found\n           {\n               \"data\": {\n                   \"status\": \"error\",\n                   \"messages\": [\n                       \"واحد مورد نظر در سیستم یافت نشد\"\n                   ],\n                   \"results\": null,\n                   \"code\": 404\n               }\n           }",
          "type": "json"
        },
        {
          "title": "Error 3: not access this section.",
          "content": "Http/1.1 403 Forbidden\n            {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                \"شما دسترسی برای این بخش را ندارید\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n          {\n               \"data\": {\n                   \"status\": \"success\",\n                   \"messages\": [\n                       \"واحد با موفقیت حذف شد\"\n                   ],\n                   \"result\": null,\n                   \"code\": 200\n               }\n           }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/single-create",
    "title": "create single unit.",
    "group": "Unit",
    "name": "Single_Create",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>عنوان واحد (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "building_id",
            "description": "<p>ایدی ساختمان. (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "charge",
            "description": "<p>مقدار شارژ واحد !-- this field access just for manager --! (optional) (required if send day_charge)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "day_charge",
            "description": "<p>روز هر ماه برای سر رسید شارژ !-- this field access just for manager --! (required if set charge)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone_number",
            "description": "<p>شماره تلفن ساکن که در این واحد سکنا میگزیند !-- this field for manager --! (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "living_people",
            "description": "<p>تعداد نفراتی که داخل واحد زندگی میکند(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "count_parkings",
            "description": "<p>تعداد پارکینگ هایی که این واحد استفاده میکند(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number_floor",
            "description": "<p>این واحد در کدام طبقه قرار دارد(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number_warehouse",
            "description": "<p>تعداد انباری هایی که این واحد استفاده میکند(optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n       \"data\": {\n           \"status\": \"error\",\n               \"messages\": [\n                   \"عنوان الزامی میباشد\",\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: building not Found;",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"ساختمان مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: cant create unit for this user.",
          "content": "Http/1.1 403 Forbidden\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"کاربر قبلا در یک واحد از ساختمان فعلی ثبت شده و امکان ثبت ندارد\"\n                ],\n                \"result\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Error 4: when set charge must set day_charge.",
          "content": "Http/1.1 422 Unprocessable Entity\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                    \"زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید\"\n                ],\n                \"results\": null,\n                \"code\": 422\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Error 5: other errors for day_charge",
          "content": "Http/1.1 422 Unprocessable Entity\n        {\n            \"data\": {\n            \"status\": \"error\",\n            \"messages\": [\n                \"روز سر رسید شارژ باید یک عدد باشد\",\n                \"کمترین مقدار روز سر رسید شارژ ۱ میباشد\",\n                \"روز سر رسید شارژ نباید بیشتر از31 باشد\"\n            ],\n            \"results\": null,\n            \"code\": 422\n            }\n        }",
          "type": "json"
        },
        {
          "title": "Error 6: when set day_charge must set charge.",
          "content": "Http/1.1 422 Unprocessable Entity\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                \"زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید\"\n                ],\n                \"results\": null,\n                \"code\": 422\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"unit\": {\n                       \"title\": \"test\",\n                       \"building_id\": \"2\",\n                       \"updated_at\": \"2021-08-14T20:57:46.000000Z\",\n                       \"created_at\": \"2021-08-14T20:57:46.000000Z\",\n                       \"id\": 44,\n                       \"code\": \"u97466644\"\n                   }\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/update",
    "title": "update one unit.",
    "group": "Unit",
    "name": "Update",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>عنوان واحد (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "charge",
            "description": "<p>مقدار شارژ واحد  (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "day_charge",
            "description": "<p>روز هر ماه برای سر رسید شارژ (optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "living_people",
            "description": "<p>تعداد نفراتی که داخل واحد زندگی میکند(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "count_parkings",
            "description": "<p>تعداد پارکینگ هایی که این واحد استفاده میکند(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number_floor",
            "description": "<p>این واحد در کدام طبقه قرار دارد(optional)</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number_warehouse",
            "description": "<p>تعداد انباری هایی که این واحد استفاده میکند(optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n       \"data\": {\n           \"status\": \"error\",\n               \"messages\": [\n                   \"ایدی ساختمان الزامی میباشد\",\n               ],\n               \"results\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 2: building not Found;",
          "content": "HTTP/1.1 404 Not Found\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"واحد مورد نظر یافت نشد\"\n               ],\n               \"results\": null,\n               \"code\": 404\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error 3: Access Deny!.",
          "content": "Http/1.1 403 Access Deny!\n        {\n            \"data\": {\n                \"status\": \"error\",\n                \"messages\": [\n                \"شما به این بخش دسترسی ندارید\"\n                ],\n                \"results\": null,\n                \"code\": 403\n            }\n        }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\n                   \"واحد با موفقیت بروز رسانی شد\"\n               ],\n               \"result\": {\n                   \"id\": 5,\n                   \"title\": \"این واحد منه\",\n                   \"building_id\": 2,\n                   \"living_people\": 4,\n                   \"count_parkings\": 4,\n                   \"number_parking\": 55,\n                   \"number_warehouse\": 44,\n                   \"number_floor\": 4,\n                   \"charge\": 444444,\n                   \"day_charge\": 4,\n                   \"code\": \"u145\",\n                   \"created_at\": \"2021-10-12T17:36:54.000000Z\",\n                   \"updated_at\": \"2021-10-12T18:03:05.000000Z\",\n                   \"deleted_at\": null,\n                   \"debt\": 0,\n                   \"rel_active_resident\": null,\n                   \"rel_building\": {\n                       \"id\": 2,\n                       \"name\": \"عباس\",\n                       \"unit\": 11,\n                       \"floor\": 5,\n                       \"manager\": 1,\n                       \"wallet\": 0,\n                       \"name_owner_bank\": \"abbass\",\n                       \"last_name_owner_bank\": \"jafari\",\n                       \"code\": \"b042\",\n                       \"image\": \"/storage/photos/building/image-2.png\",\n                       \"created_at\": \"2021-10-12T16:50:04.000000Z\",\n                       \"updated_at\": \"2021-10-12T17:08:37.000000Z\",\n                       \"deleted_at\": null,\n                       \"my_role\": \"manager\"\n                   }\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/unit/inactive-resident",
    "title": "inactive current resident one unit.",
    "group": "Unit",
    "name": "inActive",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "unit_id",
            "description": "<p>ایدی واحد (required)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value. (Bearer Token)</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error parameters: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n           {\n               \"data\": {\n               \"status\": \"error\",\n                   \"messages\": [\n                       \"ایدی واحد الزامی میباشد\",\n                   ],\n                   \"results\": null,\n                   \"code\": 422\n               }\n           }",
          "type": "json"
        },
        {
          "title": "Error 2: unit not found",
          "content": "HTTP/1.1 404 Not Found\n           {\n           \"data\": {\n           \"status\": \"error\",\n           \"messages\": [\n               \"واحد مورد نظر در سیستم یافت نشد\"\n           ],\n           \"results\": null,\n           \"code\": 404\n           }\n           }",
          "type": "json"
        },
        {
          "title": "Error 3: not access this section.",
          "content": "Http/1.1 403 Forbidden\n            {\n                \"data\": {\n                    \"status\": \"error\",\n                    \"messages\": [\n                        \"شما دسترسی برای این بخش را ندارید\",\n                        \"این واحد کاربر فعالی ندارد\"\n                    ],\n                    \"result\": null,\n                    \"code\": 403\n                }\n            }",
          "type": "json"
        },
        {
          "title": "Error 4: not done!",
          "content": "Http/1.1 503 Server Unavilable\n            {\n                \"data\": {\n                    \"status\": \"error\",\n                    \"messages\": [\n                        'عملیات  انجام نشد مجدد امتحان کنید'\n                    ],\n                    \"result\": null,\n                    \"code\": 503\n                }\n            }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n          {\n               \"data\": {\n                   \"status\": \"success\",\n                   \"messages\": [\n                       \"ساکن با موفقیت در این واحد غیر فعال شد\"\n                   ],\n                   \"result\": null,\n                   \"code\": 200\n               }\n           }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UnitsController.php",
    "groupTitle": "Unit"
  },
  {
    "type": "post",
    "url": "/api/v1/users/update",
    "title": "update information user.",
    "group": "User",
    "name": "Update",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "first_name",
            "description": "<p>user's first name (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "last_name",
            "description": "<p>user's last name  (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "numeric",
            "optional": false,
            "field": "national_code",
            "description": "<p>national code user (required)</p>"
          },
          {
            "group": "Parameter",
            "type": "file",
            "optional": false,
            "field": "avatar",
            "description": "<p>avatar's user (optional)</p>"
          }
        ]
      }
    },
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error1: data is not valid.",
          "content": "HTTP/1.1 422 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"messages\": [\n                   \"نام الزامی میباشد\",\n                   \"نام خانوادگی الزامی میباشد\",\n                   \"کد ملی الزامی میباشد\",\n                   \"کد ملی نامعتبر میباشد\",\n                   \"کد ملی قبلا در سامانه ثبت شده است\",\n                   \"نماد باید یک فایل باشد\",\n                   \"نماد باید یک عکس باشد\",\n                   \"فرمت های قابل قبول jpeg, png, jpg\"\n               ],\n               \"result\": null,\n               \"code\": 422\n           }\n       }",
          "type": "json"
        },
        {
          "title": "Error2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n                   \"status\": \"success\",\n                   \"messages\": null,\n                   \"result\": {\n                       \"user\": {\n                           \"id\": 1,\n                           \"first_name\": \"abbas\",\n                           \"last_name\": \"jafari\",\n                           \"email\": null,\n                           \"email_verified_at\": null,\n                           \"national_code\": \"0927421852\",\n                           \"phone_number\": \"09020838954\",\n                           \"avatar\": \"/storage/photos/user/avatar/user-1.png\",\n                           \"active\": 1,\n                           \"created_at\": \"2021-09-02T20:06:35.000000Z\",\n                           \"updated_at\": \"2021-09-02T20:10:35.000000Z\"\n                       }\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/v1/users/update-fcm",
    "title": "update FCM token.",
    "group": "User",
    "name": "Update_FCM_token",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": [\n                   \"توکن با موفقیت بروزرسانی شد\"\n               ],\n               \"result\": null,\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/v1/users/get-base-info",
    "title": "get total public info for current user.",
    "group": "User",
    "name": "get_base_info",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"count_notif\": 5,\n                   \"count_message\": 0\n               },\n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/api/v1/users/profile",
    "title": "get current user profile.",
    "group": "User",
    "name": "profile",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Authorization value.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n  \"Authorization\": \"Bearer {TOKEN}\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error2: Unauthorized;",
          "content": "HTTP/1.1 401 Unprocessable Entity\n       {\n           \"data\": {\n               \"status\": \"error\",\n               \"message\": [\n                   \"احراز هویت نشده اید\"\n               ],\n               \"results\": null,\n               \"code\": 401\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n       {\n           \"data\": {\n               \"status\": \"success\",\n               \"messages\": null,\n               \"result\": {\n                   \"user\": {\n                       \"id\": 1,\n                       \"first_name\": null,\n                       \"last_name\": null,\n                       \"email\": null,\n                       \"national_code\": null,\n                       \"phone_number\": \"09020838954\",\n                       \"avatar\": null,\n                       \"active\": 0,\n                       \"created_at\": \"2021-09-07T16:44:23.000000Z\",\n                       \"updated_at\": \"2021-09-07T16:44:23.000000Z\"\n                   }\n               }, \n               \"code\": 200\n           }\n       }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Api/V1/UserController.php",
    "groupTitle": "User"
  }
] });
