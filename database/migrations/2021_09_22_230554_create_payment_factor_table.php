<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentFactorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_factor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factor_id');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('factor_id')->references('id')->on('factor')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payment');
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
        Schema::dropIfExists('payment_factor');
    }
}
