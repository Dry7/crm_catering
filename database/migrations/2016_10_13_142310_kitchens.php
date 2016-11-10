<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kitchens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchens', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment = 'Название';
            $table->boolean('active')->default(1)->comment = 'Активно';
            $table->integer('sort', false, true)->index()->comment = 'Порядок';
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
        Schema::drop('kitchens');
    }
}
