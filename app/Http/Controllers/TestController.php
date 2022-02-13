<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function fcmForm(Request $request){
        return view('test');
    }
    public function fcmsend(Request $request){
        $token = $request->get('token');
        $title = $request->get('title');
        $message = $request->get('message');
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = [ $token ];

          
        $serverKey = env('GOOGLE_FCM_SERVER_KEY');
  
        $data = [
            // "registration_ids" => $FcmToken,
            // "notification" => [
            //     "title" => 'salam',
            //     "body" => 'khooobam',  
            // ]
            // "registration_ids" => $FcmToken,
            // "data" => [
            //     "notification" => [
            //         "title" => $title,
            //         "body" => $message
            //     ]
            // ]
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
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
            die('Curl failed: ' . curl_error($ch));
        }        

        // Close connection
        curl_close($ch);

        // FCM response
        $result = json_decode($result, true);
        return dd($result);
    }
}
