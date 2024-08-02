<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeSubscriptionColumnsToUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->tinyInteger('subscription_type')->after("user_type")->default(0)->comment("0=>OnetimeCharge,1=>Subscription");

            $table->string("subscription_id")->after('description')->nullable();
            $table->string("subscription_status")->after('subscription_id')->nullable();

            $table->timestamp("subscription_startdate")->after('subscription_status')->nullable();
            $table->timestamp("subscription_enddate")->after('subscription_startdate')->nullable();

            $table->string("price_id")->after('subscription_status')->nullable();
            $table->string("product_id")->after('price_id')->nullable();

            $table->string('days')->nullable()->change();
            $table->string('charge_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropColumn('subscription_type');
            $table->dropColumn('subscription_id');
            $table->dropColumn('subscription_status');
            $table->dropColumn('subscription_startdate');
            $table->dropColumn('subscription_enddate');
            $table->dropColumn('price_id');
            $table->dropColumn('product_id');
            
        });
    }
}
