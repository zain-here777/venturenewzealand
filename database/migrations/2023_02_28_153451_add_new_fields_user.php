<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('passport_thumb')->nullable()->after('phone_number')->comment('');
            $table->string('passport_exp')->nullable()->after('phone_number')->comment('');
            $table->string('passport_no')->nullable()->after('phone_number')->comment('');
            $table->string('drv_lic_thumb')->nullable()->after('phone_number')->comment('');
            $table->string('drv_lic_exp')->nullable()->after('phone_number')->comment('');
            $table->string('drv_lic_no')->nullable()->after('phone_number')->comment('');
            $table->string('postcode')->nullable()->after('phone_number')->comment('');
            $table->string('street')->nullable()->after('phone_number')->comment('');
            $table->string('suburb')->nullable()->after('phone_number')->comment('');
            $table->string('city')->nullable()->after('phone_number')->comment('');
            $table->string('state')->nullable()->after('phone_number')->comment('');
            $table->string('country')->nullable()->after('phone_number')->comment('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('passport_thumb');
            $table->dropColumn('passport_exp');
            $table->dropColumn('passport_no');
            $table->dropColumn('drv_lic_thumb');
            $table->dropColumn('drv_lic_exp');
            $table->dropColumn('drv_lic_no');
            $table->dropColumn('postcode');
            $table->dropColumn('street');
            $table->dropColumn('suburb');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
        });
    }
}
