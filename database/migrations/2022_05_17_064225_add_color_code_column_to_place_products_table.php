<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorCodeColumnToPlaceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_products', function (Blueprint $table) {
            $table->string('color_code',50)->default('#72bf44')->nullable()->after('booking_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('place_products', function (Blueprint $table) {
            $table->dropColumn('color_code');
        });
    }
}
