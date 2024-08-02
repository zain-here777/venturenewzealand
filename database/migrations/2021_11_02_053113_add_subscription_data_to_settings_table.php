<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionDataToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            
        });

        DB::table('settings')->insert(
            array(
                'name' => 'subscription_price_operator',
                'val' => '99',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );
        DB::table('settings')->insert(
            array(
                'name' => 'subscription_days_operator',
                'val' => '30',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );

        DB::table('settings')->insert(
            array(
                'name' => 'subscription_price_user',
                'val' => '49',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );
        DB::table('settings')->insert(
            array(
                'name' => 'subscription_days_user',
                'val' => '30',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')->where('name','subscription_price_operator')->delete();
            DB::table('settings')->where('name','subscription_days_operator')->delete();

            DB::table('settings')->where('name','subscription_price_user')->delete();
            DB::table('settings')->where('name','subscription_days_user')->delete();
        });
    }
}
