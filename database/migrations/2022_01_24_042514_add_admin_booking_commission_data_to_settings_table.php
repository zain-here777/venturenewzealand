<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminBookingCommissionDataToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            Schema::table('settings', function (Blueprint $table) {
                DB::table('settings')->insert(
                    array(
                        'name' => 'booking_commission_percentage',
                        'val' => '3',
                        'type' => 'string',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    )
                );
            });
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
            DB::table('settings')->where('name','booking_commission_percentage')->delete();
        });
    }
}
