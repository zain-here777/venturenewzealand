<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateBookingAvailibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_availibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default(0);
            $table->integer('product_id')->default(0);
            $table->smallInteger('is_recurring');
            $table->string('recurring_value')->nullable();
            $table->date('date')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->smallInteger('all_day');
            $table->string('booking_note')->nullable();
            $table->integer('max_booking_no')->default(0);
            $table->string('booking_cut_off')->nullable();
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
        Schema::dropIfExists('booking_availibilities');
    }
}
