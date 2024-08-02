<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnlinePaymentRequiredColumnToPlaceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_products', function (Blueprint $table) {
            $table->tinyInteger('online_payment_required')->after('featured')->default(0)->comment('0=>No,1=>Yes');
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
            $table->dropColumn('online_payment_required');
        });
    }
}
