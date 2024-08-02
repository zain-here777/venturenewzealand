<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripePriceIdDataToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')->insert(
                array(
                    'name' => 'subscription_stripe_price_id_user',
                    'val' => 'price_1KBIjYSJwc8xQyysucBAJaCq',
                    'type' => 'string',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            );
            DB::table('settings')->insert(
                array(
                    'name' => 'subscription_stripe_price_id_operator',
                    'val' => 'price_1KBIk8SJwc8xQyysdn4O9U2C',
                    'type' => 'string',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                )
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            DB::table('settings')->where('name','subscription_stripe_price_id_user')->delete();
            DB::table('settings')->where('name','subscription_stripe_price_id_operator')->delete();
        });
    }
}
