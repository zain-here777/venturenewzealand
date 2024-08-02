<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddtilemapPlaceCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries', function ($table) {
            $table->string('countrymap_tile')->nullable()->after('countrymap')->comment('');
        });
        Schema::table('cities', function ($table) {
            $table->string('map_tile')->nullable()->after('map')->comment('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function ($table) {
            $table->dropColumn('countrymap_tile');
        });
        Schema::table('cities', function ($table) {
            $table->dropColumn('map_tile');
        });
    }
}
