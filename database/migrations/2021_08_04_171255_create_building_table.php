<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('unit')->nullable();
            $table->integer('floor')->nullable();
            $table->unsignedBigInteger('manager');
            $table->foreign('manager')->references('id')->on('users');
            $table->bigInteger('wallet')->default(0)->comment('میزان مبلغی که مدیر از شرکت طلب کار است');
            $table->bigInteger('cash_desk')->default(0)->comment('صندوق مالی بین ساختمان و واحد ها');
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->text('address')->nullable();
            $table->char('sheba', 24)->nullable();
            $table->char('card_number', 16)->nullable();
            $table->char('bank_number', 12)->nullable();
            $table->string('name_owner_bank')->nullable();
            $table->string('last_name_owner_bank')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('building');
    }
}
