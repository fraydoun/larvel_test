<?php

namespace App\Notifications\notif;

use App\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateNotification extends Notification
{
    use Queueable;

    private $notifData;
    private $tokens;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notif, $tokens)
    {
        $this->notifData =  $notif;
        $this->notifData['enum'] = 'notification';
        
        $this->tokens    = collect($tokens)->reject(function($item){
            return is_null($item);
        })->toArray();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable){
        return [
            'tokens' => $this->tokens,
            'data'  => $this->notifData
        ];
    }
}
