<?php

namespace App\Http\Requests\building;

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
            'building_id' => 'required',
            'name' => 'min:3',
            'unit' => 'integer',
            'floort' => 'integer',
            'sheba' => 'min:24|max:24',
            'card_number' => 'min:16|max:16',
            'bank_number' => 'min:10|max:10',
            'name_owner_bank' => 'string',
            'last_name_owner_bank' => 'string',
            'image' => 'file|mimes:jpeg,png,jpg|max:5120',
            'city' => 'integer',
            'state' => 'integer'
        ];
    }

    public function messages()
    {
        return [
            'building_id.required' => 'ایدی ساختمان الزامی است',
            'name.min' => 'نام ساختمان حداقل باید ۳ کرکتر باشد',
            'unit.integer' => 'تعداد واحد باید یک عدد صحیح باشد',
            'floor.integer' => 'تعداد طبقات باید یک عدد صحیح باشد',
            'sheba.min' => 'شماره شبا 24 کرکتر است',
            'sheba.max' => 'شماره شبا 24 کرکتر است',
            'card_number.min' => 'شماره کارت 16 کرکتر است',
            'card_number.max' => 'شماره کارت 16 کرکتر است',
            'bank_number.min' => 'شماره حساب ۱۰ کرکتر است',
            'bank_number.max' => 'شماره حساب ۱۰ کرکتر است',
            'name_owner_bank.string' => 'نام صاحب حساب باید رشته باشد',
            'last_name_owner_bank.string' => 'نام خانوادگی صاحب حساب باید رشته باشد',
            'image.file' => 'عکس باید یک فایل باشد',
            'image.mimes' => 'فرمت های قابل قبول jpeg, png, jpg',
            'image.max' => 'حجم عکس نباید بیش از 5 مگابایت باشد',
            'city.integer' => 'ایدی شهر یک عدد است',
            'state.integer' => 'ایدی استان یک عدد است',
        ];
    }
}
