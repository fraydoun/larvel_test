<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsFormItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_form_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ads_id');
            // $table->unsignedBigInteger('factor_item_id');
            $table->unsignedBigInteger('form_item_id');
            $table->text('value');
            $table->foreign('ads_id')->references('id')->on('ads');
            $table->foreign('form_item_id')->references('id')->on('form_item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_form_item');
    }
}
