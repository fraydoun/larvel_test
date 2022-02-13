<?php

namespace App\Http\Requests\factor;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'building_id' => 'required|integer',
            'units' => ['required', 'regex:/\[[0-9,]+[0-9]*\]/'],
            'title'   => 'required|string|min:5|max:150',
            'price'   => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
          'building_id.required' => 'اید واحد الزامی است',
          'building_id.integer' => 'ایدی واحد باید یک عدد باشد',
          'units.required' => 'ایدی واحد های مد نظر را باید بفرستید',
          'units.regex' => 'فرمت ارسالی ایدی واحد ها درست نمیباشد',
          'price.required' => 'هزینه فاکتور را باید بفرستید',
          'price.integer' => 'هزینه باید یک عدد صحیح باشد',
          'title.required' => 'عنوان فاکتور الزامی میباشد',
          'title.min' => 'حداقل کارکتر های عنوان باید 5 حرف باشد',
          'title.max' => 'حداکثر کارکتر های عنوان باید 150 حرف باشد'
        ];
    }
}
