<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDeletedFieldInBookingAvailibilityTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_availibility_time_slots', function (Blueprint $table) {
            $table->tinyInteger('is_deleted')->nullable()->default(0)->comment('0 = no, 1 = yes')->after('edit_id');
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
            $table->dropColumn('is_deleted');
        });
    }
}
