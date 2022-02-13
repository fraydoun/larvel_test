<?php

namespace App\Components\services\charge;

use App\Components\services\charge\ChargeInterface;
use App\Models\Payment;
use App\Notifications\services\BuyChargeTopupNotif;
use App\Notifications\services\BuyInternetNotif;
use App\Notifications\services\PaymentBillNotif;

Class Inax implements ChargeInterface{

    const PAY_TYPE_ONLINE = 'online';
    const PAY_TYPE_CREDIT = 'credit';

    const METHOD_TOPUP      = 'topup'; // شارژ مستقیم
    const METHOD_BILL       = 'bill'; // پرداخت قبض
    const METHOD_CHECK_BILL = 'check_bill'; // بررسی نوع و مبلغ قبض
    const METHOD_PRODUCTS   = 'get_products'; // لیست بسته های اینترنت
    const METHOD_INTERNET   = 'internet'; // خرید بسته اینترنت
    
    const API_URL = 'https://inax.ir/webservice.php';

    private $username;
    private $password;
    private $response;

    private $sanboxMode;
    
    public function __construct()
    {
        $this->username = env('INAX_USERNAME_API');
        $this->password = env('INAX_PASSWORD_API');
        
        $this->sanboxMode = env('INAX_SANBOX_MODE', false);
    }

    public  function topup($data){

        $this->response =  $this->request(Inax::METHOD_TOPUP, $data);
        return $this;
    }


    /**
     * check bill 
     */
    public function checkBill($data){
        $this->response = $this->request(Inax::METHOD_CHECK_BILL, $data);

        return $this;
    }

    /**
     * payment bill.
     */
    public function bill($data){
        $this->response = $this->request(Inax::METHOD_BILL, $data);
        return $this;
    }

    /**
     * get all products
     */
    public function products(){
        $this->response = $this->request(Inax::METHOD_PRODUCTS, []);
        return $this;
    }

    /**
     * get link payment internet
     */
    public function internet($data){
        $this->response = $this->request(Inax::METHOD_INTERNET, $data);
        return $this;
    }
    public function requestIsOk()
    {
        if(! $this->response) return false;

        return $this->response['code'] == 1;
    }

    public function linkPayment(){
        if($this->requestIsOk())
            return $this->response['url'];

        return false;
    }

    public function response()
    {
        return $this->response;
    }
    private  function request($method, $param){

        if (!is_string($method)) {
            error_log("Method name must be a string\n");
            return false;
        }

        if (!$param) {
            $param = [];
        }else if (!is_array($param)) {
            error_log("Parameters must be an array\n");
            return false;
        }

        $parameters = [
            'username'		=> $this->username,
            'password'		=> $this->password,
            'method'		=> $method,
            'test_mode'     => $this->sanboxMode,
            'pay_type'      => self::PAY_TYPE_ONLINE
        ];

        if(isset($param) && !empty($param)){
            foreach( $param as $key => $value)
                $parameters[$key] = $value;
        }


        $handle = curl_init(self::API_URL);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_ENCODING, "");
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

        return $this->exec_curl_request($handle);
    }

    private  function exec_curl_request($handle) {
        $response = curl_exec($handle);
        if ($response === false) {
            $errno = curl_errno($handle);
            $error = curl_error($handle);
            error_log("Curl returned error $errno: $error\n");
            curl_close($handle);
            return false;
        }
    
        $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
        curl_close($handle);
    
        if ($http_code >= 500) {
            // do not wat to DDOS server if something goes wrong
            sleep(5);
            return false;
        }
        elseif ($http_code != 200) {
            $response = json_decode($response, true);
            error_log("Request has failed with error {$response['error_code']}: {$response['msg']}\n");
            if ($http_code == 401) {
                throw new \Exception('Invalid access token provided');
            }
            return false;
        }
        else{
            $response = json_decode($response, true);
            if (isset($response['msg'])  ) {
                //error_log("Request was successfull: {$response['msg']}\n");
            }
            //$response = $response['code'];
        }
        return $response;
    }

    public function checkTransaction(Payment $payment)
    {
        $response = $this->request('trans_status', ['trans_id' => $payment->pay_data['trans_id']]);
        $this->response = $response;
        return $response['payment_status'] == 'paid';
    }

    public function getNotificationClass()
    {
        if(! isset($this->response['product'])){
            return false;
        }

        switch($this->response['product']){

            case self::METHOD_INTERNET: 
                return BuyInternetNotif::class;
                break;

            case self::METHOD_TOPUP:
                return BuyChargeTopupNotif::class;
                break;

            case self::METHOD_BILL:
                return PaymentBillNotif::class;
                break;

        }
    }
}