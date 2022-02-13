<?php

namespace App\Http\Livewire\Dashboard\Settings\Sms\Factors;

use App\Models\SmsText;
use Livewire\Component;

class PaymentManualConfirm extends Component
{
    const KEY = 'payment_manual_confirm';

    public $text;
    private $repository;



    protected $rules = [
        'text' => 'required'
    ];

    protected $messages = [
        'text.required' => 'متن پیامک حتما باید وارد شود',
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
        return view('livewire.dashboard.settings.sms.factors.payment-manual-confirm');
    }
}
