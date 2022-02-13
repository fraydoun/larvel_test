<?php

namespace App\Http\Requests\unit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'unit_id' => 'required',
            'title' => 'string|min:3|max:50',
            'charge' => 'integer|required_with:day_charge',
            'day_charge' => 'numeric|min:1|max:31|required_with:charge'
        ];
    }

    public function messages()
    {
        return [
            'unit_id.required' => 'ایدی واحد الزامی میباشد',
            'title.string' => 'عنوان باید یک رشته باشد',
            'title.min' => 'حداقل طول عنوان باید ۳ کرکتر باشد',
            'title.max' => 'حداکثر طول عنوان باید ۵۰ کرکتر باشد',
            'charge.integer' => 'مقدار شارژ باید یک عدد صحیح باشد',
            'charge.required_with' => 'زمانی که روز سر رسید شارژ را انتخاب کردید، باید مقدار شارژ را مشخص کنید',
            'day_charge.required_with' => 'زمانی که شارژ را وارد کرده اید، روز رسید شارژ را باید مشخص کنید',
            'day_charge.numeric' => 'روز سر رسید شارژ باید یک عدد باشد',
            'day_charge.min' => 'کمترین مقدار روز سر رسید شارژ ۱ میباشد',
            'day_charge.max' => 'روز سر رسید شارژ نباید بیشتر از31 باشد'
        ];
    }
}
