<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use phpDocumentor\Reflection\Types\Integer;

class AddMaxColumnsToBookingAvailibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_availibilities', function (Blueprint $table) {
            $table->integer('max_adult_per_room')->nullable()->after('booking_cut_off');
            $table->integer('max_child_per_room')->nullable()->after('booking_cut_off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_availibilities', function (Blueprint $table) {
            $table->dropColumn('max_adult_per_room');
            $table->dropColumn('max_child_per_room');
        });
    }
}
