<?php

namespace App\Http\Livewire\Dashboard\Settings\Sms\Factors;

use App\Models\SmsText;
use App\Repositories\SmsTextRepository;
use Livewire\Component;

class FactorCreated extends Component
{
    const KEY = 'create_factor';

    public $text;
    private $repository;



    protected $rules = [
        'text' => 'required|regex:/.*{factor_title}.*/'
    ];

    protected $messages = [
        'text.required' => 'متن پیامک حتما باید وارد شود',
        'text.regex' => 'درون متن باید کلید {factor_title} قرار بگیرد',
    ];

    public function mount(){
        $text =  SmsText::where('key', self::KEY)->first();
        if($text){
            $this->text = $text->text;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.settings.sms.factors.factor-created');
    }

    public function save(){
        $this->validate();
        
        SmsText::insertOrUpdate(self::KEY, $this->text);
        session()->flash('success', 'متن با موفقیت ثبت شد');
    }
}
