<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_item', function (Blueprint $table) {
            $table->id();
            $table->char('title', 225);
            $table->char('slug', 225);
            $table->char('type_field', '225')->comment('نوع فیلد مثل تکست باکس یا تک انتخابی');
            $table->integer('price')->nullable()->comment('اگر مقدار داشت اون اگهی به همین مقدار که دارد پول اضافه میشود که کاربر باید پرداخت بکنه');
            $table->text('settings')->nullable();
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
        Schema::dropIfExists('form_item');
    }
}
