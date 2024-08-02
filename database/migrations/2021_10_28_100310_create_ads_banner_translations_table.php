<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsBannerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('ads_banner_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();

            $table->unique(['ads_banner_id', 'locale']);
            $table->foreign('ads_banner_id')->references('id')->on('ads_banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_banner_translations');
    }
}
