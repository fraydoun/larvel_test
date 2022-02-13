<?php

namespace App\Http\Requests\payment;

use Illuminate\Foundation\Http\FormRequest;

class ManualPaymentConfirmationRequest extends FormRequest
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
            'payment_id' => 'required',
            'confirmation' => 'required|integer|between:0,1'
        ];
    }

    public function messages()
    {
        return [
            'unit_id.required' => 'ایدی واحد الزامی میباشد',
            'payment_id.required' => 'ایدی پرداخت الزامی میباشد',
            'confirmation.required' => 'کد تایید الزامی میباشد',
            'confirmation.integer' => 'کد تایید یک عدد صحیح میباشد',
            'confirmation.between' => 'کد تایید عدد 1 یا 0 میباشد'
        ];
    }
}
