<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('addres');
            $table->string('name');
            $table->string('phone');
            $table->string('way_delivery');
            $table->string('porch');
            $table->text('floor');
            $table->string('time_delivery');
            $table->string('odd_money');
            $table->integer('hour');
            $table->integer('min');
            $table->integer('cafe_id');
            $table->text('comment');
            $table->text('promo');
            $table->text('discount');
            $table->integer('status');
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
        Schema::dropIfExists('order');
    }
}
