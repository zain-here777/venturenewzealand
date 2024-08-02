<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeConnectAccountColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_account_id')->after('stripe_customer_id')->nullable();
            $table->string('stripe_access_token')->after('stripe_account_id')->nullable();
            $table->string('stripe_refresh_token')->after('stripe_access_token')->nullable();
            $table->string('stripe_token_type')->after('stripe_refresh_token')->nullable();
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
            $table->dropColumn('stripe_account_id');
            $table->dropColumn('stripe_access_token');
            $table->dropColumn('stripe_refresh_token');
            $table->dropColumn('stripe_token_type');
        });
    }
}
