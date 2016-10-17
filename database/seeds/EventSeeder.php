<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('events')->truncate();
        factory(\App\Models\Event::class, 1000)->create();
    }
}
