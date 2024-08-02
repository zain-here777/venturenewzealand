<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('place_id');

            $table->string('name');
            $table->string('description');
            $table->decimal('price',8,2)->nullable();
            $table->string('thumb')->nullable();

            $table->decimal('discount_percentage',8,2)->nullable();
            $table->timestamp("discount_start_date")->nullable();
            $table->timestamp("discount_end_date")->nullable();
            
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
        Schema::dropIfExists('place_products');
    }
}
