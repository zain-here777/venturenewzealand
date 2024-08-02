<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingAvailibilityTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_availibility_time_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_availibility_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('booking_note')->nullable();
            $table->integer('max_booking_no')->default(0);
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
        Schema::dropIfExists('booking_availibility_time_slots');
    }
}
