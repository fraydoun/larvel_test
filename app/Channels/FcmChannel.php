<?php

namespace App\Channels;

use Exception;
use Illuminate\Notifications\Notification;

class FcmChannel{
    const URL = 'https://fcm.googleapis.com/fcm/send';
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toFcm($notifiable);
        if($data){
            if(! isset($data['tokens'], $data['data'])){
                throw new Exception('token not set for Firebase Notif');
            }
    
            $this->sendToFcm($data);
        }
    }


    private function sendToFcm($data){    
        $serverKey = env('GOOGLE_FCM_SERVER_KEY');
  
        $data = [
            "registration_ids" => $data['tokens'],
            "data" => [
                "notification" => $data['data']
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            return false;
        }        

        // Close connection
        curl_close($ch);

        // FCM response
        return json_decode($result, true);      
    }
}