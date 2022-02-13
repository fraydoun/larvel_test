<?php

namespace App\Notifications\factor;

use App\Channels\FcmChannel;
use App\Channels\SmsChannel;
use App\Models\SmsText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class NotifCreate extends Notification
{
    use Queueable;
    const KEY = 'create_factor';

    public $typeSend = 'normal';
    private $factors;
    private $users;

    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $factors, array $users)
    {
        $this->factors = $factors;
        $this->users = $users;

        $message = SmsText::getText(self::KEY);
        $this->message = str_replace('{factor_title}', $this->factors[0]->title, $message);
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
     * send message 
     */
    public function toSms($notifiable){
        
        return [
            'phone_number' => Arr::pluck($this->users, 'phone_number'),
            'message' => [$this->message]
        ];
    }


    public function toFcm($notifiable){
        return [
            'tokens' => Arr::pluck($this->users, 'token_fcm'),
            'data' => [
                'title' => 'یک فاکتور برای شما ایجاد شد',
                'message' => $this->message,
                // 'id' => $this->factors[0]['id'],
                'enum' => 'factors'
            ]
        ];
    }
}
