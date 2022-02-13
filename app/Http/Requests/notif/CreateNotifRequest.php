<?php

namespace App\Http\Requests\notif;

use Illuminate\Foundation\Http\FormRequest;

class CreateNotifRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'building_id' => 'required',
            'users' => ['regex:/\[[0-9,]+[0-9]*\]/'],
            'title' => 'required|max:100|min:3',
            'message' => 'required|string',
            'file' => 'file|mimes:jpeg,png,jpg,zip,rar|max:5120'
        ];
    }

    public function messages(){
        return [
            'building_id.required' => 'ایدی ساختمان الزامی میباشد',
            'users.regex' => 'فرمت ارسالی ایدی کاربر ها درست نمیباشد',
            'title.required' => 'عنوان الزامی میباشد',
            'title.max' => 'حداکثر کرکتر های عنوان ۱۰۰ کرکتر میباشد',
            'title.min' => 'حداقل کرکتر های عنوان ۳ کرکتر میباشد',
            'message.required' => 'متن پیام الزامی میباشد',
            'messgae.string' => 'متن پیام باید یک رشته باشد',
            'file.file' => 'عکس باید یک فایل باشد',
            'file.mimes' => 'فرمت های قابل قبول jpeg, png, jpg, zip, rar',
            'file.max' => 'حجم عکس نباید بیش از 5 مگابایت باشد',
        ];
    }
}
