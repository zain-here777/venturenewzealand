<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedProductLimitDataToSettingsTable extends Migration
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
                'name' => 'is_place_featured_products_limited_for_operator',
                'val' => '1',
                'type' => 'string',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            )
        );

        DB::table('settings')->insert(
            array(
                'name' => 'place_featured_products_limit_for_operator',
                'val' => '1',
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
            DB::table('settings')->where('name','is_place_featured_products_limited_for_operator')->delete();
            DB::table('settings')->where('name','place_featured_products_limit_for_operator')->delete();
        });
    }
}
