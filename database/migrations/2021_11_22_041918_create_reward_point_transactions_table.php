<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardPointTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_point_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('user_id');
            $table->bigInteger('place_id');
            $table->decimal('points',8,2);
            $table->tinyInteger("transaction_type")->default(1)->comment("1=>Add,2=>Minus");
            $table->decimal('balance',8,2)->nullable();
            
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
        Schema::dropIfExists('reward_point_transactions');
    }
}
