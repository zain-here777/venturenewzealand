<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedColumnToPlaceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_products', function (Blueprint $table) {
            $table->tinyInteger('featured')->after('discount_end_date')->default(0)->comment('0=>Not,1=>Featured');
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
            $table->dropColumn('featured');
        });
    }
}
