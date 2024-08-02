<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToBookingAvailibilityTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_availibility_time_slots', function (Blueprint $table) {
            $table->date('date')->nullable()->comment('store for edit and delete')->after('max_booking_no');
            $table->tinyInteger('type')->nullable()->comment('0 = delete 1 = edit')->after('max_booking_no');
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
            $table->dropColumn('date');
            $table->dropColumn('type');
        });
    }
}
