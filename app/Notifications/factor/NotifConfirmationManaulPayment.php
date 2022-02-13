<?php

namespace App\Notifications\factor;

use App\Channels\DBNotifChannel;
use App\Channels\FcmChannel;
use App\Channels\SmsChannel;
use App\Models\Factor;
use App\Models\Notification as ModelsNotification;
use App\Models\Payment;
use App\Models\SmsText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifConfirmationManaulPayment extends Notification
{
    use Queueable;

    const KEY_CONFIRM = 'payment_manual_confirm';
    const KEY_REJECT = 'payment_manual_reject';
    public $typeSend = 'normal';

    private $payment;
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;

        if($this->payment->status == Factor::STATUS_PAYED){
            $this->message = SmsText::getText(self::KEY_CONFIRM);
            // $message = 'فاکتور های که بصورت نقدی پرداخت کردید مورد تایید مدیر قرار گرفت' ;
        }else if($this->payment->status == Factor::STATUS_REJECT_CONFIRM_BY_MANAGER){
            $this->message = smsText::getText(self::KEY_REJECT);
            // $message = 'فاکتور هایی  که بصورت نقدی پرداخت کردید مورد تایید مدیر قرار نگرفت  پس از بررسی های لازم لطفا اقدام به پرداخت کنید';
        }
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
                'title' => 'پرداخت نقدی فاکتور',
                'message' => $this->message,
                'enum' => 'factors'
            ]
        ];
    }
}
