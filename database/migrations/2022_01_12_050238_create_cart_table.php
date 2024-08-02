<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');

            $table->bigInteger('place_id');
            $table->bigInteger('place_product_id');

            $table->integer('number_of_adult')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();

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
        Schema::dropIfExists('cart');
    }
}
