<?php


namespace App\Channels;

use App\Components\sms\Sms;
use Illuminate\Notifications\Notification;

class SmsChannel
{

    const TYPE_SEND_NORMAL = 'normal';
    const TYPE_SEND_ULTRA  = 'ultra';
    const TYPE_VERIFICATION = 'verification';
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        
       
        $data = $notification->toSms($notifiable);
        
        $sender = new Sms();
        if($notification->typeSend == self::TYPE_SEND_NORMAL){

            $res = $sender->sendNormal($data['phone_number'], $data['message']);

        }else if($notification->typeSend == self::TYPE_SEND_ULTRA){
            
            $sender->sendUltra($data);

        }else if($notification->typeSend == self::TYPE_VERIFICATION){
            $sender->sendVerification($data['code'], $data['phone_number']);
        }


      

    }
}