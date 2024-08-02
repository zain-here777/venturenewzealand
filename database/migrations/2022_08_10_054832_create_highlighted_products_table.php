<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHighlightedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('highlighted_products', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->bigIncrements('id');
            $table->bigInteger('place_product_id')->unsigned();
            $table->foreign('place_product_id')
            ->references('id')->on('place_products')
            ->onDelete('cascade');
            $table->tinyInteger('status')->default(1)->comment('0 = inactive,1 = active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('highlighted_products');
    }
}
