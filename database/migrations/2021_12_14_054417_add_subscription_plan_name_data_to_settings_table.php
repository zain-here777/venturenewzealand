<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionPlanNameDataToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });

        DB::table('settings')->insert(
            array(
                'name' => 'subscription_plan_name_operator',
                'val' => 'Operator Venture',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );

        DB::table('settings')->insert(
            array(
                'name' => 'subscription_plan_name_user',
                'val' => 'Yearly Venture',
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
            DB::table('settings')->where('name','subscription_plan_name_operator')->delete();
            DB::table('settings')->where('name','subscription_plan_name_user')->delete();
        });
    }
}
