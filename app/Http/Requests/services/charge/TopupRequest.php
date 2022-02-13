<?php

namespace App\Http\Requests\services\charge;

use App\Models\Factor;
use App\Rules\WhereRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TopupRequest extends FormRequest
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
            'operator' => 'required|in:MTN,MCI,RTL,SHT',
            'amount' => [
                            'required', 
                            (new WhereRule())->where(['operator' => 'in:MTN,RTL'], 'integer|between:500,50000', 'مبلغ باید مقادیر 500 و 50000 باشد')
                                                        ->where(['operator' => 'in:MCI'], 'in:1000,2000,5000,10000,20000', 'مبلغ باید یکی از مقادیر (1000, 2000, 5000, 10000, 20000) باشد')
                        ],
            'phone_number' => 'required|max:11|regex:/^09[0-9].{8}/',
            'charge_type' => 'required|in:normal,amazing',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'مبلغ شارژ باید وارد شود',
            'operator.required' => 'یک اپراتو ابتدا مشخص کنید',
            'operator.in' => 'اپراتور باید مقادیر MTN,MCI,RTL,SHT داشته باشد',
            'phone_number.required' => 'شماره تلفنی که میخواهید شارژ بشود را وارد کنید',
            'phone_number.max' => 'شماره تلفن باید حداکثر ۱۱ کرکتر باشد',
            'phone_number.regex' => 'فرمت شماره تلفن صحیح نیست',
            'charge_type.required' => 'نوع شارژ باید ارسال شود',
            'charge_type.in' => 'نوع شارژ باید یکی از مقادیر normal, amazing باشد'
        ];
    }


    // public function getValidatorInstance(){
    //     return parent::getValidatorInstance()->after(function($validator){
    //         $data = $this->request->all();

    //         $this->request->add([
    //             'owner' => Auth::id(),
    //             'creator' => Auth::id(),
    //             'type' => Factor::TYPE_SYSTEM,
    //             'type' => Factor::STATUS_NOT_PAY,
    //             'item_type' => Factor::ITEM_TYPE_CHARGE_MOBILE,
    //             'item_id' => null,
    //             'count' => 1,
    //             'title' => 'خرید شارژ',
    //             'price' => $this->request->get('amount'),
    //             'pay_data' => json_encode([
    //                 'operator' => $this->request->get('operator'),
    //                 'phone_number' => $this->request->get('phone_number'),
    //                 'charge_type' => $this->request->get('charge_type')
    //             ])
    //         ]);
    //     });
    // }

}
