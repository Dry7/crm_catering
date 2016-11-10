<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->string('code')->unique()->comment = 'Код';
            $table->string('name')->comment = 'Название';
            $table->integer('section1', false, true)->nullable()->index()->comment = 'Раздел 1';
            $table->integer('section2', false, true)->nullable()->index()->comment = 'Раздел 2';
            $table->integer('section3', false, true)->nullable()->index()->comment = 'Раздел 3';
            $table->integer('section4', false, true)->nullable()->index()->comment = 'Раздел 4';
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
        Schema::drop('categories');
    }
}
