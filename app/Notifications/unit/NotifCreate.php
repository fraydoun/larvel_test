<?php

namespace App\Notifications\unit;

use App\Channels\FcmChannel;
use App\Channels\SmsChannel;
use App\Components\sms\Sms;
use App\Models\Unit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifCreate extends Notification
{
    use Queueable;
    public $typeSend = 'ultra';
    private $unit;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
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
    * send sms
     */
    public function toSms($notifiable){
        return [
            "ParameterArray" =>[
                [
                    "Parameter" => "unitCode",
                    "ParameterValue" => $this->unit->code
                ]
            ],
            "Mobile" => $notifiable->phone_number,
            "TemplateId" => Sms::TEMPLATE_UNIT_CODE
        ];
    }

    public function toFcm($notifiable){
        return [
            'tokens' => [$notifiable->token_fcm],
            'data' => [
                'title' => 'یک واحد ایجاد شد',
                'title' => 'واحدی برای شما ایجاد شده است',
                'unit_data' => $this->unit->toArray(),
                'enum' => 'units'
            ]
        ];
    }
}
