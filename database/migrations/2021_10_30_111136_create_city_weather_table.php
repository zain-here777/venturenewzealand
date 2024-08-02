<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_weather', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('city_id');
            $table->string('city_name');
            $table->string('temprature');
            $table->string('temprature_phrase');
            $table->tinyInteger('unit')->default(0)->comment("0=>Fahrenheit,1=>Celsius");
            $table->string('icon_url')->default('');
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
        Schema::dropIfExists('city_weather');
    }
}
