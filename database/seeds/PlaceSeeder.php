<?php

use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('places')->truncate();
        \App\Models\Place::create(['id' => 1, 'name' => 'Мраморный Дворец']);
        \App\Models\Place::create(['id' => 2, 'name' => 'Екатерининский дворей']);
        \App\Models\Place::create(['id' => 3, 'name' => 'Дом архитектора']);
        \App\Models\Place::create(['id' => 4, 'name' => 'Петропаловская крепость']);
        \App\Models\Place::create(['id' => 5, 'name' => 'Выездное мероприятие']);
    }
}
