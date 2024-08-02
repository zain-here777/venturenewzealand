<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditIdToBookingAvailibilityTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_availibility_time_slots', function (Blueprint $table) {
            $table->bigInteger('edit_id')->nullable()->comment('id of edited booking_availibility_time_slots')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_availibility_time_slots', function (Blueprint $table) {
            $table->dropColumn('edit_id');
        });
    }
}
