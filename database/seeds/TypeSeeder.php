<?php

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('types')->truncate();
        Type::create(['id' => 1, 'name' => 'Закуски',  'sort' => 1]);
        Type::create(['id' => 2, 'name' => 'Основное', 'sort' => 2]);
        Type::create(['id' => 3, 'name' => 'Десерт',   'sort' => 3]);
        Type::create(['id' => 4, 'name' => 'Напитки',  'sort' => 4]);
    }
}
