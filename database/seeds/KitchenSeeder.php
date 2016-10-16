<?php

use Illuminate\Database\Seeder;
use App\Models\Kitchen;

class KitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('kitchens')->truncate();
        Kitchen::create(['id' => 1, 'name' => 'Японская',    'sort' => 1]);
        Kitchen::create(['id' => 2, 'name' => 'Русская',     'sort' => 2]);
        Kitchen::create(['id' => 3, 'name' => 'Итальянская', 'sort' => 3]);
    }
}
