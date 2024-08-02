<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->tinyInteger('user_type')->comment("1=>User,2=>Operator");
            $table->bigInteger('price')->comment("Price x 100")->nullable();
            $table->integer('days');
            $table->timestamp('purchase_date');
            $table->string('charge_id');
            $table->string('charge_status')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('txn_status')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('user_subscriptions');
    }
}
