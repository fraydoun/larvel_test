<?php

namespace App\Http\Requests\user;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequset extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'national_code' => [ /* 'required', */ new NationalCode()],
            'avatar' => 'file|image|mimes:jpeg,png,jpg|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'نام الزامی میباشد',
            'last_name.required' => 'نام خانوادگی الزامی میباشد',
            // 'national_code.required' => 'کد ملی الزامی میباشد',
            'avatar.file' => 'نماد باید یک فایل باشد',
            'avatar.image' => 'نماد باید یک عکس باشد',
            'avatar.mimes' => 'فرمت های قابل قبول jpeg, png, jpg',
            'avatar.max' => 'حجم عکس نباید بیش از 5 مگابایت باشد'
        ];
    }
}
