<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Staff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            $table->string('surname')->nullable()->comment = 'Фамилия';
            $table->string('patronymic')->nullable()->comment = 'Отчество';
            $table->enum('job', ['admin', 'manager', 'cook'])->default('manager')->comment = 'Должность';
            $table->string('username')->nullable()->comment = 'Логин';
            $table->boolean('active')->default(true)->comment = 'Доступ';
            $table->boolean('work_hours')->default(false)->comment = 'Доступ только в рабочие часы';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'patronymic', 'job', 'username', 'active', 'work_hours']);
        });
    }
}
