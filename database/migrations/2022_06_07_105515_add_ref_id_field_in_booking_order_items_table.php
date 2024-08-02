<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefIdFieldInBookingOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_order_items', function (Blueprint $table) {
            $table->bigInteger('ref_id')->nullable()->comment('booking_availibility_slot_id')->after('booking_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_order_items', function (Blueprint $table) {
            $table->dropColumn('ref_id');
        });
    }
}
