<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id');

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('message', 500)->nullable();

            $table->decimal('total_amount',8,2)->nullable();
            $table->decimal('payable_amount',8,2)->nullable();
            
            $table->tinyInteger('payment_status')->default(0)->comment('0=>Pending,1=>Completed,2=>NotRequired');

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
        Schema::dropIfExists('booking_orders');
    }
}
