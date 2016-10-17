<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index()->comment = 'Менеджер';
            $table->integer('status_id', false, true)->default(1)->index()->comment = 'Статус';
            $table->integer('client_id', false, true)->index()->comment = 'Клиент';
            $table->date('date')->nullable()->comment = 'День рождения';
            $table->integer('format_id', false, true)->nullable()->index()->comment = 'Формат';
            $table->integer('persons', false, true)->nullable()->index()->comment = 'Количество персон';
            $table->integer('tables', false, true)->nullable()->index()->comment = 'Количество столов';
            $table->integer('place_id', false, true)->nullable()->index()->comment = 'Место проведения';
            $table->integer('staff', false, true)->nullable()->index()->comment = 'Количество STAFF питания';
            $table->time('meeting')->nullable()->comment = 'Время встречи гостей';
            $table->time('main')->nullable()->comment = 'Время основного проекта';
            $table->time('hot_snacks')->nullable()->comment = 'Время горячей закуски';
            $table->time('sorbet')->nullable()->comment = 'Время сорбет';
            $table->time('hot')->nullable()->comment = 'Время горячего';
            $table->time('dessert')->nullable()->comment = 'Время десерта';
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
        Schema::drop('events');
    }
}
