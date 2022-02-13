<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type_bank')->comment('ایدی درگاه پرداختی که انجام شده');
            $table->text('pay_data')->nullable()->comment('اطلاعاتی که از درگاه دریافت میشه');
            $table->unsignedBigInteger('payer');
            $table->foreign('payer')->references('id')->on('users');
            $table->tinyInteger('status')->comment('وضعیت پرداخت');// 0 is not payed. 1 cancelled , ... 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
