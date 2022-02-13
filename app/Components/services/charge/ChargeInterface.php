<?php

namespace App\Components\services\charge;

use App\Models\Payment;

interface ChargeInterface{

    /**
     * متد خرید شارژ مستقیم
     */
    public function topup($data);

    /**
     * اطلاعات قبض رو بر میگردونه
     */
    public function checkBill($data);

    /**
     * متد درخواست پرداخت قبض
     */
    public function bill($data);

    /**
     * دریافت لیست تمام بسته های اینترنت
     */
    public function products();

    /**
     * متد درخواست خرید بسته اینترنت
     */
    public function internet($data);
    /**
     * بررسی میکنه که ایا پرداخت موفقیت امیز بوده یا نه
     */
    public function checkTransaction(Payment $payment);

    /**
     * ریکویستی که سمت سرویس دهند زده ریسپانس موفقیت امیز گرفته یا نه
     */
    public function requestIsOk();

    /**
     * دریافت لینک پرداخت
     */    
    public function linkPayment();

    /**
     * ریسپانس های هر مرحله رو میده
     */
    public function response();

    /**
     * بر اساس اینکه چه سرویسی خریده شده نام کلاس نوتیفیکشن رو میده
     */
    public function getNotificationClass();

}