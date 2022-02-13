<?php

namespace App\Notifications\services;

use App\Channels\DBNotifChannel;
use App\Channels\FcmChannel;
use App\Models\Notification as ModelsNotification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BuyChargeTopupNotif extends Notification
{
    use Queueable;

    private $factor;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $factor)
    {
        $this->factor = $factor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, DBNotifChannel::class];
    }

    public function toFcm($notifiable){
        $payer = User::find($this->factor['owner']);
        if(! $payer) return [];
        return [
            'tokens' => [$payer->token_fcm],
            'data'  => $this->factor
        ];
    }

    public function toDbNotif($notifiable){
        return [
            'sender' => ModelsNotification::SENDER_SYSTEM,
            'receiver' => $notifiable->id,
            'title' => 'خرید شارژ',
            'message' => 'شارژ با موفقیت انجام شد',
            'type' => ModelsNotification::TYPE_NOTIFICATION,
            'action' => [
                'textButton' => 'بررسی فاکتور',
                'part' => 'factors',
                'id' => $this->factor['id'],
            ]
        ];
    }

}
