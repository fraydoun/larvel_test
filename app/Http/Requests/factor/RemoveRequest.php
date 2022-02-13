<?php

namespace App\Http\Requests\factor;

use Illuminate\Foundation\Http\FormRequest;

class RemoveRequest extends FormRequest
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
            'factor_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'factor_id.required' => 'ایدی فاکتور الزامی میباشد'
        ];
    }
}
