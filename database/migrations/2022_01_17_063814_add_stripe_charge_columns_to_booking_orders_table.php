<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeChargeColumnsToBookingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_orders', function (Blueprint $table) {
            $table->string('payment_intent_id')->nullable()->after('payment_status');
            $table->string('payment_intent_status')->nullable()->after('payment_intent_id');
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
            $table->dropColumn('payment_intent_id');
            $table->dropColumn('payment_intent_status');
        });
    }
}
