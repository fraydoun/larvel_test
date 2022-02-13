<?php


namespace App\Components\sms;
use App\Components\sms\Classes\SendMessage;
use App\Components\sms\Classes\SmsIR_UltraFastSend;
use App\Components\sms\Classes\UltraFastSend;
use App\Components\sms\Classes\VerificationCode;

class Sms
{
    const TEMPLATE_UNIT_CODE = 53266;
    const TEMPLATE_PAYMENT_FACTOR = 55247;

    private $apiKey;
    private $secretKey;
    private $sanbox;

    private $template = 53107;



    private $lineNumber = 30004505004249;
    private $apiUrl = "https://ws.sms.ir/";
    public function __construct()
    {
        $this->apiKey = env('SMS_API_KEY');
        $this->secretKey = env('SMS_SECRET_KEY');
        $this->sanbox = env('SMS_SANBOX_MODE', false);
    }

    /**
     * @param $code integer
     * @param $number integer
     *
     * send message very fast just a few second.
     */
    public function sendUltra($data){
        if($this->sanbox) return true;
        $ultra = new UltraFastSend($this->apiKey, $this->secretKey);
        try{
            $res = $ultra->UltraFastSend($data);
            return $res;
        }catch (\Exception $e){
            return false;
        }

    }

    /**
     * @param $code string
     * @param $number integer
     *
     * send message via simple template.
     */
    public function sendVerification($code, $number){
        if($this->sanbox) return true;
        $verificationCode = new VerificationCode($this->apiKey, $this->secretKey);

        try{
            $result = $verificationCode->VerificationCode($code, $number);
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * @param $code string
     * @param $number string
     */
    public function sendUnitCode($code, $phone_number){
        $data = [
            "ParameterArray" =>[
                [
                    "Parameter" => "unitCode",
                    "ParameterValue" => $code
                ]
            ],
            "Mobile" => $phone_number,
            "TemplateId" => $this->templateUnitCode
        ];

        return $this->sendUltra($data);
    }

    /**
     * @param $code string
     * @param $number string
     */
    public function sendPaymentRefId($ref_id, $phone_number){
        $data = [
            "ParameterArray" =>[
                [
                    "Parameter" => "ref_id",
                    "ParameterValue" => $ref_id
                ]
            ],
            "Mobile" => $phone_number,
            "TemplateId" => $this->templatePaymentFactor
        ];
        return $this->sendUltra($data);
    }

    /**
     * send normat message to group user
     */
    public function sendNormal($mobiles, $message, $time=''){

        if($this->sanbox) return true;
        $sender = new SendMessage($this->apiKey, $this->secretKey, $this->lineNumber, $this->apiUrl);
        return $sender->SendMessage($mobiles, $message, $time);
    }
}
