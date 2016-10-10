<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index()->comment = 'Менеджер';
            $table->string('name')->comment = 'Название';
            $table->string('phone_work')->comment = 'Рабочий телефон';
            $table->string('phone_mobile')->nullable()->comment = 'Мобильный телефон';
            $table->string('fio')->comment = 'ФИО';
            $table->string('job')->comment = 'Должность';
            $table->date('birthday')->comment = 'День рождения';
            $table->string('email')->comment = 'E-mail';
            $table->text('events')->comment = 'Проводимые мероприятия';
            $table->string('site')->nullable()->comment = 'Адрес сайта';
            $table->text('address')->nullable()->comment = 'Адрес (местонахождение)';
            $table->text('description')->nullable()->comment = 'Краткое описание клиента';
            $table->text('hobby')->nullable()->comment = 'Хобби';
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
        Schema::drop('clients');
    }
}
