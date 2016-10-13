<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Product;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit('/products')->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/products')->see('Меню');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit('/products')->dontSee('Меню')->seePageIs('/');
    }

    /**
     * See index clients as admin
     */
    public function testIndexCountAdmin()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Product::class)->create(['name' => 'name1', 'weight' => 1, 'price' => 50,     'kitchen_id' => 1, 'type_id' => 1]);
        factory(\App\Models\Product::class)->create(['name' => 'name2', 'weight' => 100, 'price' => 200.10, 'kitchen_id' => 2, 'type_id' => 2]);
        factory(\App\Models\Product::class)->create(['name' => 'name3', 'weight' => 1000, 'price' => 33000,  'kitchen_id' => 3, 'type_id' => 3]);

        $this->actingAs($user)->visit('/products')
            ->see('name1')->see('50.00 р.')->see('1 гр.')->see('Японская')->see('Закуска')
            ->see('name2')->see('200.10 р.')->see('100 гр.')->see('Русская')->see('Основное')
            ->see('name3')->see('33 000.00 р.')->see('1 000 гр.')->see('Итальянская')->see('Десерт');
    }

}
