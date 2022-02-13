<?php


namespace App\Channels;

use App\Components\sms\Sms;
use App\Models\Notification as ModelsNotification;
use App\Repositories\NotificationRepository;
use Illuminate\Notifications\Notification;

class DBNotifChannel
{


    private $notif;

    public function __construct(NotificationRepository $notif)
    {
        $this->notif = $notif;
    }
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        $data = $notification->toDbNotif($notifiable);
        $this->notif->create($data);
    }
}