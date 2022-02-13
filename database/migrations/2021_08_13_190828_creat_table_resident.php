<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatTableResident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resident', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('building_id')->references('id')->on('building');
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resident');
    }
}
