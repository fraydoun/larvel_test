<?php

namespace App\Http\Requests\payment;

use Illuminate\Foundation\Http\FormRequest;

class ManualPaymentRequest extends FormRequest
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
            'factor_ids' =>  ['required', 'regex:/\[[0-9,]+[0-9]*\]/'],
            'document' => 'file|mimes:jpeg,png,jpg|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'unit_id.required' => 'ایدی واحد الزامی میباشد',
            'factor_ids.required' => 'ایدی درگاه پرداخت الزامی میباشد',
            'factor_ids.regex' => 'فرمت ارسالی فاکتور ها صحیح نمیباشد',
            'document.file' => 'عکس باید یک فایل باشد',
            'document.mimes' => 'فرمت های قابل قبول jpeg, png, jpg',
            'document.max' => 'حجم عکس نباید بیش از 5 مگابایت باشد',
        ];
    }
}
