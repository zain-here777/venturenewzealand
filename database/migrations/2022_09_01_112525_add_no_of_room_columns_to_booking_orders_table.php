<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoOfRoomColumnsToBookingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_orders', function (Blueprint $table) {
            $table->integer('no_of_room')->nullable()->after('payment_intent_status')->comment('number of room for stay category.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_orders', function (Blueprint $table) {
            $table->dropColumn('no_of_room');
        });
    }
}
