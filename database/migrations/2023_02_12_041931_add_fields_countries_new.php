<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCountriesNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('countries', function (Blueprint $table) {
                $table->string('video')->nullable()->after('status')->comment('');
                $table->string('website')->nullable()->after('status')->comment('');
                $table->string('countrymap')->nullable()->after('status')->comment('');
                $table->string('banner')->nullable()->after('status')->comment('');
                $table->text('about')->nullable()->after('status')->comment('');
                $table->string('description')->nullable()->after('status')->comment('');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('about');
            $table->dropColumn('banner');
            $table->dropColumn('countrymap');
            $table->dropColumn('website');
            $table->dropColumn('video');
        });
    }
}
