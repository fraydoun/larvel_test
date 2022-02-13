<?php

namespace App\Http\Requests\payment;

use Illuminate\Foundation\Http\FormRequest;

class ListPaymentsBuildingRequest extends FormRequest
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
            'building_id' => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'building_id.required' => 'ایدی ساختمان الزامی میباشد'
        ];
    }
}
