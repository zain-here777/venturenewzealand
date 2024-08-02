<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1=>Broadcast,2=>Single,3=OneToOne');
            $table->tinyInteger('delete_type')->default(NULL)->comment('1=>Start,2=>End')->nullable();
            $table->bigInteger('place_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('for_user_id')->nullable();
            $table->bigInteger('from_user_id')->nullable();
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
        Schema::dropIfExists('web_notifications');
    }
}
