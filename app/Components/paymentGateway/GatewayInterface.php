<?php
namespace App\Components\paymentGateway;

interface GatewayInterface{
    /**
     * send request to gate
     */
    public function request(array $data);
}