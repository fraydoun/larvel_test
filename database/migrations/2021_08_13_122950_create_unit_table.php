<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->char('title', 50)->nullable();
            $table->unsignedBigInteger('building_id');
            $table->integer('living_people')->nullable();
            $table->integer('count_parkings')->nullable();
            $table->integer('number_parking')->nullable();
            $table->integer('number_warehouse')->nullable();
            $table->integer('number_floor')->nullable();
            $table->bigInteger('charge')->default(0)->nullable();
            $table->integer('day_charge')->nullable();
            $table->string('code')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('building_id')->references('id')->on('building');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit');
    }
}
