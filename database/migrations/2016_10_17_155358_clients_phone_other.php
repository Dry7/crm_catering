<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientsPhoneOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table){
            $table->string('phone_other')->nullable()->comment = 'Дополнительный телефон';
            $table->string('phone_other2')->nullable()->comment = 'Дополнительный телефон 2';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table){
            $table->dropColumn(['phone_other', 'phone_other2']);
        });
    }
}
