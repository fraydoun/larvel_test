<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver');
            $table->unsignedBigInteger('sender');



            $table->string('title');
            $table->longText('message');
            $table->string('file')->nullable();
            $table->json('action')->nullable(); // اگر روی یک نوتیفکیشن کلیکی انجام شد و خواست منتقل بشه به یک جایی از برنامه
            $table->tinyInteger('type'); // if 1 == notification, 2 == pv message , ... 
            $table->tinyInteger('seen')->default(0); 
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('receiver')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
