<?php

use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('logging')->truncate();
        factory(\App\Models\Log::class, 10000)->create();
    }
}
