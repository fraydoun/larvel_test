<?php

namespace App\Http\Requests\services\internet;

use Illuminate\Foundation\Http\FormRequest;

class InternetRequest extends FormRequest
{
    const INTERNET_TYPES = [
        'hourly',
        'daily',
        'weekly',
        'monthly',
        'yearly',
        'amazing',
        'TDLTE'
    ];
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
            'product_id'    => 'required',
            'operator'      => 'required|in:MTN,MCI,RTL,SHT',
            'mobile'        => 'required|max:11|regex:/^09[0-9].{8}/',
            'internet_type' => 'required|in:'.implode(',', self::INTERNET_TYPES),
            'sim_type'      => 'required|in:credit,permanent',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required'   => 'ایدی بسته الزامی میباشد',
            'operator.required'     => 'اپراتور الزامی میباشد',
            'operator.in'           => 'مقادیر اپراتور باید یکی از موارد (MTN, MCI, RTL, SHT) باشد',
            'mobile.required' => 'شماره تلفن الزامی میباشد',
            'mobile.max'      => 'شماره تلفن نباید بیش از ۱۱ کرکتر باشد',
            'mobile.regex'    => 'فرمت شماره تلفن صحیح نمیباشد',
            'internet_type.required'=> 'نوع بسته اینترنت الزامی میباشد',
            'internet_type.in'      => 'نوع بسته اینترنت باید مقادیر ('. implode(',', self::INTERNET_TYPES) .') داشته باشد',
            'sim_type.required'     => 'نوع سیمکارت باید مشخص شود',
            'sim_type.in'           => 'نوع سیمکارت باید مقادیر (credit, permanent) داشته باشد'
        ];
    }

}
