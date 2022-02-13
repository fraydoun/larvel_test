<?php

namespace App\Notifications\factor;

use App\Channels\FcmChannel;
use App\Channels\SmsChannel;
use App\Components\sms\Sms;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotifPaymentSuccessfull extends Notification
{
    use Queueable;

    public $typeSend = 'ultra';
    private $payment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class, FcmChannel::class];
    }

    /**
     * send sms
     */
    public function toSms(){
        return [
            "ParameterArray" =>[
                [
                    "Parameter" => "ref_id",
                    "ParameterValue" => $this->payment->pay_data['ref_id'] ?? $this->payment->id
                ]
            ],
            "Mobile" => $this->payment->relPayer->phone_number,
            "TemplateId" => Sms::TEMPLATE_PAYMENT_FACTOR
        ];
    }


    public function toFcm($notifiable){
        $user = Auth::user();
        if(! $user){
            $user = $this->payment->relPayer;
        }

        if(! $user->token_fcm){
            return false;
        }
        return [
            'tokens' => [$user->token_fcm],
            'data' => [
                'title' => 'پرداخت با موفقیت انجام شد',
                'message' => 'فاکتور با موفقیت انجام شد',
                'payment' => $this->payment->toArray(),
                'enum' => 'factors'
            ]
        ];
    }
}
