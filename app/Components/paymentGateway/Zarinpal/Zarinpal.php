<?php
namespace App\Components\paymentGateway\Zarinpal;

use App\Components\paymentGateway\GatewayInterface;
use App\Models\Payment;
use Exception;
use SoapClient;

class Zarinpal implements GatewayInterface
{

    private $merchant_id;
    private $sanbox     = false;
    private $url_sanbox = 'https://sanbox.zarinpal.com/pg/StartPay/';
    private $url        = 'https://www.zarinpal.com/pg/StartPay/';

    private $callback_url;

    private Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->merchant_id = env('MERCHANT_ID_ZARINPAL');
        $this->sanbox      = env('SANBOX_MODE_ZARINPAL');


        $this->payment = $payment;
    }


    public function request($data)
    {
        
        if(! isset($data['callback'])){
            throw new Exception('not set callback');
        }
        $callbackParams = $data['callbackParams'] ?? [];
        $callback       = $data['callback'];
        if(count($callbackParams) > 0){
            $i = 0;
            foreach ($callbackParams as $name => $value){
                if($i == 0) {
                    $callback .= '?';
                }else{
                    $callback .= '&';
                }
                $callback .= $name.'='.$value;
                $i++;
            }
        }
        
        if($this->sanbox)
        {
            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }
        else
        {
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }


        $result = $client->PaymentRequest(
            [
                'MerchantID'  => $this->merchant_id,
                'Amount'      => $this->payment->totalPrice(),
                'Description' => $this->payment->getDescription(),
                // 'Email'       => $this->payment->relPayer->email,
                'Mobile'      => $this->payment->relPayer->phone_number,
                'CallbackURL' => $callback,
            ]
        );
        if($result->Status != 100) return false;
        $payData = [
            'status' => $result->Status,
            'authority' => $result->Authority
        ];

        $payData = array_merge($payData, $this->payment->pay_data);

        
        return $this->payment->update(['pay_data' => $payData]);
    }

    public function verify()
    {
        if($this->sanbox){
            $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }else{
            $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        }
        $result = $client->PaymentVerification(
            [
                'MerchantID' => $this->merchant_id,
                'Authority'  => $this->payment->pay_data['authority'],
                'Amount'     => $this->payment->totalPrice(),
            ]
        );

        // $this->_status = $result->Status;
        // $this->_ref_id = $result->RefID;
        if($result->Status != 100) return false;

        $data = $this->payment->pay_data;
        $data['ref_id'] = $result->RefID;

        return $this->payment->update(['pay_data' => $data]);
    }

  

    public function getRedirectUrl($zaringate = true)
    {
        if($this->sanbox){
            $url = 'https://sandbox.zarinpal.com/pg/StartPay/'. $this->payment->pay_data['authority'];
        }else{
            $url = 'https://www.zarinpal.com/pg/StartPay/'.$this->payment->pay_data['authority'];
        }
        $url .=  ($zaringate) ? '/ZarinGate' : '';

        return $url;
    }

   
    
}
