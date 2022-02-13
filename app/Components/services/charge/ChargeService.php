<?php
namespace App\Components\services\charge;



//get instance of service Charge.
class ChargeService{
    public static function getInstance(){
        $service = 'inax';

        return new Inax();
    }
}