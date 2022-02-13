<?php

namespace App\Notifications\auth;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationCode extends Notification
{
    use Queueable;

    public $typeSend = 'verification';
    private $validationCode;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->validationCode = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * send validation code as sms.
     */
    public function toSms($notifiable){
        return [
            'phone_number' => $notifiable->phone_number,
            'code' => $this->validationCode->code
        ];
    }
}
