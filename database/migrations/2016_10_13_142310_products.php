<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('source', ['file', 'hand'])->default('file')->comment = 'Способ добавления';
            $table->integer('section1', false, true)->nullable()->index()->comment = 'Раздел 1';
            $table->integer('section2', false, true)->nullable()->index()->comment = 'Раздел 2';
            $table->integer('section3', false, true)->nullable()->index()->comment = 'Раздел 3';
            $table->integer('section4', false, true)->nullable()->index()->comment = 'Раздел 4';
            $table->integer('kitchen_id', false, true)->nullable()->index()->comment = 'Кухня';
            $table->integer('type_id',    false, true)->nullable()->index()->comment = 'Тип блюда';
            $table->string('name')->comment = 'Название';
            $table->string('name_en')->nullable()->comment = 'Название на английском';
            $table->integer('weight')->unsigned()->comment = 'Вес, гр.';
            $table->double('price', 32, 2)->nullable()->comment = 'Цена, р.';
            $table->string('photo', 255)->nullable()->comment = 'Фотография';
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
        Schema::drop('products');
    }
}
