<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsWeightPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table){
            $table->boolean('weight_person')->default(false)->comment = 'Указывать выход на персону';
            $table->integer('tax_id')->default(1)->comment = 'Налоги';
            $table->string('template')->default('default')->comment = 'Шаблон';
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
            $table->dropColumn(['weight_person', 'tax_id', 'template']);
        });
    }
}
