<?php

namespace App\Http\Requests\services\bill;

use App\Models\Factor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BillPaymentRequest extends FormRequest
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
            'bill_id' => 'required',
            'pay_id'  => 'required',
        ];
    }

    public function messages(){
        return [
            'bill_id.required' => 'شناسه قبض الزامی میباشد',
            'pay_id.required' => 'شناسه پرداخت الزامی میباشد'
        ];
    }

  
}
