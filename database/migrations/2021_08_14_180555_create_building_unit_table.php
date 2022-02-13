<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('building_id')->references('id')->on('building');
            $table->foreign('unit_id')->references('id')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_unit');
    }
}
