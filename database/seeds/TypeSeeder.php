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
        Type::create(['id' => 2, 'name' => 'Салаты', 'sort' => 2]);
        Type::create(['id' => 3, 'name' => 'Холодные блюда',   'sort' => 3]);
        Type::create(['id' => 4, 'name' => 'Горячие блюда',  'sort' => 4]);
        Type::create(['id' => 5, 'name' => 'Десерты',  'sort' => 4]);
        Type::create(['id' => 6, 'name' => 'Напитки',  'sort' => 4]);
        Type::create(['id' => 7, 'name' => 'Барбекю/гриль',  'sort' => 4]);
        Type::create(['id' => 8, 'name' => 'Шоу-блюдо',  'sort' => 4]);
    }
}
