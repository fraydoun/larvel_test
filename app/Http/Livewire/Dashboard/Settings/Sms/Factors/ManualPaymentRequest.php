<?php

namespace App\Http\Livewire\Dashboard\Settings\Sms\Factors;

use App\Models\SmsText;
use Livewire\Component;

class ManualPaymentRequest extends Component
{
    const KEY = 'manual_payment_request';

    public $text;
    private $repository;



    protected $rules = [
        'text' => ['required', 'regex:/(.*{factor_title}.*{user_name}.*)|(.*{user_name}.*{factor_title}.*)/']
    ];

    protected $messages = [
        'text.required' => 'متن پیامک حتما باید وارد شود',
        'text.regex' => 'درون متن باید کلید های {factor_title} و {user_name} قرار بگیرد',
    ];

    public function mount(){
        $text =  SmsText::where('key', self::KEY)->first();
        if($text){
            $this->text = $text->text;
        }
    }



    public function save(){
        $this->validate();
        
        SmsText::insertOrUpdate(self::KEY, $this->text);
        session()->flash('success', 'متن با موفقیت ثبت شد');
    }
    
    public function render()
    {
        return view('livewire.dashboard.settings.sms.factors.manual-payment-request');
    }
}
