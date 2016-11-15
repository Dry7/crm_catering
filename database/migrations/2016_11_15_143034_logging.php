<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Logging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logging', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index()->comment = 'Менеджер';
            $table->string('event')->comment = 'Событие';
            $table->integer('element_id', false, true)->nullable()->comment = 'Элемент';
            $table->string('element_name')->nullable()->comment = 'Название элемента';
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
        Schema::drop('logging');
    }
}
