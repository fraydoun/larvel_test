<?php

namespace App\Http\Requests\factor;

use App\Models\Factor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BuyChargeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->request->add([
            'owner' => Auth::id(),
            'creator' => Auth::id(),
            'type' => Factor::TYPE_SYSTEM,
            'type' => Factor::STATUS_PAYED,
            'item_type' => Factor::ITEM_TYPE_CHARGE_MOBILE,
            'item_id' => null,
            'count' => 1
        ]);
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
            'title' => 'required',
            // 'description' => 'required',
            'price' => 'required',
            'pay_data' => 'json'
        ];
    }

    public function messages()
    {
        return[
            'title.required' => 'عنوان الزامی است',
            'price.required' => 'مبلغ شارژ الزامی است',
            'pay_data.json' => 'اطلاعات پرداختی باید رشته جیسون باشد'
        ];
    }
}
