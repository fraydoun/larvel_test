<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor', function (Blueprint $table) {
            $table->id();
            $table->char('title', 225);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('owner');
            $table->unsignedBigInteger('creator');
            $table->bigInteger('price');
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('item_type')->nullable(); // مشخص میکنید که این فاکتور برای چه قسمتی هست . مثلا شارژ ساختمان یا هزینه اضافی یا ...
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedInteger('count')->default(1);
            $table->integer('part')->nullable()->comment('مشخص میکنه مثلا این فاکتور برای چه چیزی ایجاد شده. مثلا شارژ بوده یا تعمیرات یا غیره...');
            $table->timestamp('payment_deadline')->nullable();
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
        Schema::dropIfExists('factor');
    }
}
