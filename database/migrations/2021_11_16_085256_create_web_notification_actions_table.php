<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebNotificationActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_notification_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notification_id');
            $table->bigInteger('user_id');
            $table->timestamp('read_at')->nullable()->default(NULL);
            $table->timestamp('delete_at')->nullable()->default(NULL);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_notification_actions');
    }
}
