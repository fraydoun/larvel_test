<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->char('title', 100);
            $table->unsignedBigInteger('parent')->nullable();
            $table->char('icon', 225)->nullable();
            $table->char('category', 50)->comment('دسته بندی برای چه بخشی است');
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
        Schema::dropIfExists('ads_category');
    }
}
