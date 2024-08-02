<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();

            $table->string('image')->nullable();

            $table->decimal('entry_fee_points',8,2)->nullable();
            $table->decimal('prize_points',8,2)->nullable();            
            
            $table->timestamp("start_date")->nullable();
            $table->timestamp("end_date")->nullable();

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
        Schema::dropIfExists('competitions');
    }
}
