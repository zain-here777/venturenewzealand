<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPlacetranslationAddNeedtobring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_translations', function (Blueprint $table) {
            $table->string('needtobring')->nullable()->after('description')->comment('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('place_translations', function (Blueprint $table) {
            $table->dropColumn('needtobring');
        });
    }
}
