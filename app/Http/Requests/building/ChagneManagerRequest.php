<?php

namespace App\Http\Requests\building;

use Illuminate\Foundation\Http\FormRequest;

class ChagneManagerRequest extends FormRequest
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
            'phone_number_new_manager' => 'required|regex:/^09[0-9].{8}/',
            'sheba' => 'min:24|max:24',
            'card_number' => 'min:16|max:16',
            'bank_number' => 'min:10|max:10',
            'name_owner_bank' => 'string',
            'last_name_owner_bank' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'building_id.required' => 'ایدی ساختمان الزامی میباشد',
            'phone_number_new_manager.required' => 'شماره تلفن مدیر جدید الزامی میباشد',
            'phone_number_new_manager.regex' => 'شماره تلفن بصورت صحیح وارد نشده است',
            'sheba.min' => 'شماره شبا 24 کرکتر است',
            'sheba.max' => 'شماره شبا 24 کرکتر است',
            'card_number.min' => 'شماره کارت 16 کرکتر است',
            'card_number.max' => 'شماره کارت 16 کرکتر است',
            'bank_number.min' => 'شماره حساب ۱۰ کرکتر است',
            'bank_number.max' => 'شماره حساب ۱۰ کرکتر است',
            'name_owner_bank.string' => 'نام صاحب حساب باید رشته باشد',
            'last_name_owner_bank.string' => 'نام خانوادگی صاحب حساب باید رشته باشد',
        ];
    }
}
