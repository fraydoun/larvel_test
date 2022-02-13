<?php

namespace App\Http\Livewire\Dashboard\Settings\Sms\Notification;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class PushNotification extends Component
{
    public $title;
    public $text;
    
    protected $rules = [
        'title' => 'required',
        'text' => 'required'
    ];
    
    protected $messages = [
        'title.required' => 'عنوان پوش نوتیفیکیشن حتما باید وارد شود',
        'text.required' => 'متن پوش نوتیفیکیشن حتما باید وارد شود',
    ];
    public function render()
    {
        return view('livewire.dashboard.settings.sms.notification.push-notification');
    }
    
    public function save(){
        $this->validate();
        //Now select all users to send them the notifications by it's token_fcm
        $users = User::where('token_fcm','!=',"")->get('token_fcm');;
        
        
        $title = $this->title;
        $message = $this->text;
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $serverKey = env('GOOGLE_FCM_SERVER_KEY');
        
        foreach($users as $user){
            // print $user->token_fcm;
            
            $token=$user->token_fcm;
            $FcmToken = [ $token ];
            $data = [
                
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
            }
            session()->flash('success', 'پوش نوتیفیکیشن با موفقیت ارسال شد');
            // return dd($result);
        }
    }
    