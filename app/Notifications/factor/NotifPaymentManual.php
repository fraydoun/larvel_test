<?php

namespace App\Notifications\factor;

use App\Channels\DBNotifChannel;
use App\Channels\FcmChannel;
use App\Channels\SmsChannel;
use App\Models\Notification as ModelsNotification;
use App\Models\Payment;
use App\Models\SmsText;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class NotifPaymentManual extends Notification
{
    use Queueable;
    const KEY = 'manual_payment_request';

    public $typeSend = 'normal';

    private $payment;
    private $descriptionPayment;
    private $payerPayment;

    private $message;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;

        $this->descriptionPayment = $payment->getDescription();
        $this->payerPayment = $payment->relPayer;

        $message = SmsText::getText(self::KEY);
        $this->message = str_replace(['{factor_title}', '{user_name}'], [$this->payment->getDescription(), $this->payment->relPayer->fullName], $message);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DBNotifChannel::class, SmsChannel::class, FcmChannel::class];
    }


    public function toDbNotif($notifiable){
        return [
            'sender' => ModelsNotification::SENDER_SYSTEM,
            'receiver' => $notifiable->id,
            'title' => 'پرداخت نقدی فاکتور',
            'message' => $this->message,
            'type' => ModelsNotification::TYPE_NOTIFICATION,
            'action' => [
                'textButton' => 'بررسی فاکتور',
                'part' => 'factors',
                'id' => $this->payment->id,
            ]
        ];
    }


    public function toSms($notifiable)
    {
        return [
            'phone_number' => [$notifiable->phone_number],
            'message' => [$this->message]
        ];
    }


    public function toFcm($notifiable){
        return [
            'tokens' => [$notifiable->token_fcm],
            'data' => [
                'title' => 'پرداخت نقدی توسط مدیر بررسی شد',
                'message' => $this->message,
                'enum' => 'factors'
            ]
        ];
    }

}
