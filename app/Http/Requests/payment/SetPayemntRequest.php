<?php

namespace App\Http\Requests\payment;

use Illuminate\Foundation\Http\FormRequest;

class SetPayemntRequest extends FormRequest
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
            'gate_id' => 'required',
            'device' => 'required',
            'factor_ids' =>  ['required', 'regex:/\[[0-9,]+[0-9]*\]/'],
        ];
    }

    public function messages()
    {
        return [
            'gate_id.required' => 'ایدی درگاه پرداخت الزامی میباشد',
            'factor_ids.required' => 'فاکتوری برای پرداخت باید انتخاب شود',
            'factor_ids.regex' => 'فرمت ارسالی فاکتور ها صحیح نمیباشد',
            'device.required' => 'نوع دیوایس باید مشخص شود (web, android, ios)'
        ];
    }
}
