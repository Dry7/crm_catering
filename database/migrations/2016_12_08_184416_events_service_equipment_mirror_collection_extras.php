<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventsServiceEquipmentMirrorCollectionExtras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table){
            $table->string('service')->nullable()->comment = 'Сервис';
            $table->string('equipment')->nullable()->comment = 'Оборудование';
            $table->string('mirror_collection')->nullable()->comment = 'Пробочный сбор';
            $table->string('extras')->nullable()->comment = 'Доп. наценка';
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
            $table->dropColumn(['service', 'equipment', 'mirror_collection', 'extras']);
        });
    }
}
