<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventAdministrationFare extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table){
            $table->string('administration')->nullable()->comment = 'Административные расходы';
            $table->string('fare')->nullable()->comment = 'Транспортные расходы';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table){
            $table->dropColumn(['administration', 'fare']);
        });
    }
}
