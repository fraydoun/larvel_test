<?php
namespace App\Components\paymentGateway;

use App\Components\paymentGateway\Zarinpal\Zarinpal;
use App\Models\Payment;

final class Gateway{
    const zarinPalGateway = 1;

    public static function getInstance(Payment $payment){
        switch($payment->type_bank){
            case self::zarinPalGateway : 
                return new Zarinpal($payment);
        }
    }
}