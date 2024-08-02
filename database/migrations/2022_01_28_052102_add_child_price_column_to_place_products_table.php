<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChildPriceColumnToPlaceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_products', function (Blueprint $table) {
            $table->decimal('child_price',8,2)->after('price')->nullable();
            $table->decimal('child_discount_price',8,2)->after('child_price')->nullable();
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
            $table->dropColumn('child_price');
            $table->dropColumn('child_discount_price');
        });
    }
}
