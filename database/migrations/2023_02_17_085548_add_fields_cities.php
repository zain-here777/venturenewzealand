<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->string('video')->nullable()->after('banner')->comment('');
            $table->string('website')->nullable()->after('banner')->comment('');
            $table->string('map')->nullable()->after('banner')->comment('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('map');
            $table->dropColumn('website');
            $table->dropColumn('video');
        });
    }
}
