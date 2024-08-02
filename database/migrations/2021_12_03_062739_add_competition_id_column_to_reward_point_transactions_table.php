<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompetitionIdColumnToRewardPointTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_point_transactions', function (Blueprint $table) {
            $table->bigInteger('place_id')->nullable()->change();
            $table->bigInteger("competition_id")->after("place_id")->nullable();
            $table->string("title")->after("balance")->nullable();
            $table->string("description")->after("title")->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_point_transactions', function (Blueprint $table) {
            $table->dropColumn('competition_id');
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
}
