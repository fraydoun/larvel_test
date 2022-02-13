<?php

namespace App\Jobs\factor;

use App\Components\sms\Sms;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotifPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendSms();
        
    }


    private function sendSms(){
        $sender = new Sms();
        $ref_id = $this->payment->pay_data['ref_id'] ?? $this->payment->id;

        $res = $sender->sendPaymentRefId($ref_id, $this->payment->relPayer->phone_number);
    }
}
