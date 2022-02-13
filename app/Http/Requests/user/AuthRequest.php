<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    // pattern of route.
    const Auth = '*auth';
    const Verify = '*verify';
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
        $rules = [
            'phone_number' => 'required|max:11|regex:/^09[0-9].{8}/'
        ];

        if($this->is(self::Verify)){
            $rules['code'] = 'required';
            $rules['phone_number'] .= '|exists:users,phone_number';
        }

        return $rules;
    }

    /**
     * set custom message for rules.
     */
    public function messages()
    {
        return [
            'phone_number.required' => 'شماره تلفن الزامی میباشد',
            'phone_number.max' => 'طول شماره تلفن باید 11 کارکتر باشد',
            'phone_number.regex' => 'شماره تلفن بصورت صحیح وارد نشده است',
            'phone_number.exists' => 'شماره تلفن در سامانه ثبت نشده است',
            'code.required' => 'کد تایید الزامی است',
        ];
    }
}
