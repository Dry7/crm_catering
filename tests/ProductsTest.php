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

        factory(\App\Models\Kitchen::class)->create(['id' => 1, 'name' => 'Японская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 2, 'name' => 'Русская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 3, 'name' => 'Итальянская']);

        factory(\App\Models\Type::class)->create(['id' => 1, 'name' => 'Закуска']);
        factory(\App\Models\Type::class)->create(['id' => 2, 'name' => 'Основное']);
        factory(\App\Models\Type::class)->create(['id' => 3, 'name' => 'Десерт']);

        factory(\App\Models\Product::class)->create(['name' => 'name1', 'weight' => 1, 'price' => 50,     'kitchen_id' => 1, 'type_id' => 1]);
        factory(\App\Models\Product::class)->create(['name' => 'name2', 'weight' => 100, 'price' => 200.10, 'kitchen_id' => 2, 'type_id' => 2]);
        factory(\App\Models\Product::class)->create(['name' => 'name3', 'weight' => 1000, 'price' => 33000,  'kitchen_id' => 3, 'type_id' => 3]);

        $this->actingAs($user)->visit('/products')
            ->see('name1')->see('50.00 р.')->see('1 гр.')->see('Японская')->see('Закуска')
            ->see('name2')->see('200.10 р.')->see('100 гр.')->see('Русская')->see('Основное')
            ->see('name3')->see('33 000.00 р.')->see('1 000 гр.')->see('Итальянская')->see('Десерт');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit('/products/create')->seePageIs('/login');
    }

    /**
     * Create as manager
     */
    public function testCreateAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager']);

        $this->actingAs($user)->visit('/products/create')->dontSee('Создать блюдо');
    }

    /**
     * Create as admin
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Kitchen::class)->create(['id' => 1, 'name' => 'Русская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 2, 'name' => 'Японская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 3, 'name' => 'Итальянская']);
        factory(\App\Models\Type::class)->create(['id' => 1, 'name' => 'Закуска']);
        factory(\App\Models\Type::class)->create(['id' => 2, 'name' => 'Горячее']);
        factory(\App\Models\Type::class)->create(['id' => 3, 'name' => 'Суп']);

        $this->actingAs($user)->visit('/products/create')
            ->see('Создать блюдо')
            ->type('name',  'name')
            ->type('100',   'weight')
            ->type('12345', 'price')
            ->type('1', 'kitchen_id')
            ->type('1', 'type_id')
            ->press('Сохранить')
            ->seeInDatabase('products', [
                'name'   => 'name',
                'weight' => '100',
                'price'  => '12345',
                'kitchen_id'  => 1,
                'type_id'  => 1
            ]);
    }

    /**
     * Create as admin short
     */
    public function testCreateAsAdminShort()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Kitchen::class)->create(['id' => 1, 'name' => 'Русская']);
        factory(\App\Models\Type::class)->create(['id' => 1, 'name' => 'Закуска']);

        $this->actingAs($user)->visit('/products/create')
            ->see('Создать блюдо')
            ->type('name',  'name')
            ->type('100',   'weight')
            ->press('Сохранить')
            ->seeInDatabase('products', [
                'name'   => 'name',
                'weight' => '100',
                'price'  => null,
                'kitchen_id'  => null,
                'type_id'  => null
            ]);
    }

    /**
     * Create without name
     */
    public function testCreateRequired()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/products/create')
            ->see('Создать блюдо')
            ->press('Сохранить')
            ->dontSeeInDatabase('clients', [
                'weight' => '200',
                'price'  => '100'
            ])
            ->see('Поле name обязательно для заполнения.')
            ->see('Поле weight обязательно для заполнения.');
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\Models\Product::class)->create(['id' => 1, 'name' => 'name1', 'weight' => 100, 'price' => 200]);

        $this->visit('/products/1/edit')->seePageIs('/login');
    }

    /**
     * Create as manager
     */
    public function testUpdateAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);

        factory(Product::class)->create(['id' => 1, 'name' => 'name', 'weight' => 100]);

        $this->actingAs($user)->visit('/products/1/edit')->dontSee('Редактировать блюдо');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Kitchen::class)->create(['id' => 1, 'name' => 'Русская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 2, 'name' => 'Японская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 3, 'name' => 'Итальянская']);
        factory(\App\Models\Type::class)->create(['id' => 1, 'name' => 'Закуска']);
        factory(\App\Models\Type::class)->create(['id' => 2, 'name' => 'Горячее']);
        factory(\App\Models\Type::class)->create(['id' => 3, 'name' => 'Суп']);

        factory(\App\Models\Product::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20,
            'type_id' => 1,
            'kitchen_id' => 1
        ]);

        $this->actingAs($user)->visit('/products/2/edit')
            ->see('Редактировать блюдо')
            ->see('name')
            ->see('403')
            ->see('10000.2')
            ->type('name2', 'name')
            ->type('305',   'weight')
            ->type('12',    'price')
            ->select(2,    'type_id')
            ->select(2,    'kitchen_id')
            ->press('Сохранить')
            ->seeInDatabase('products', [
                'id'     => 2,
                'name'   => 'name2',
                'weight' => '305',
                'price'  => '12',
                'kitchen_id'  => '2',
                'type_id'  => '2',
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Kitchen::class)->create(['id' => 1, 'name' => 'Русская']);
        factory(\App\Models\Kitchen::class)->create(['id' => 2, 'name' => 'Японская']);
        factory(\App\Models\Type::class)->create(['id' => 1, 'name' => 'Закуска']);
        factory(\App\Models\Type::class)->create(['id' => 2, 'name' => 'Горячее']);

        factory(\App\Models\Product::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20
        ]);

        $this->actingAs($user)->visit('/products/2/edit')
            ->see('Редактировать блюдо')
            ->type('',      'name')
            ->type('',      'weight')
            ->press('Сохранить')
            ->dontSeeInDatabase('products', [
                'id'     => 2,
                'name'   => '',
                'weight' => null,
            ])
            ->see('Поле name обязательно для заполнения.')
            ->see('Поле weight обязательно для заполнения.');
    }

    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\Models\Product::class)->create(['id' => 2]);

        $this->delete('/products/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\Models\Product::class)->create(['id' => 2, 'name' => 'name']);

        $this->actingAs($user)->delete('/products/2');
        $this->assertResponseStatus(302);
        $this->seeInDatabase('products', ['id' => 2]);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Product::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20
        ]);

        $this->actingAs($user)->visit('/products/2/edit')
            ->press('Удалить')
            ->seePageIs('/products')->dontSeeInDatabase('products', [ 'id' => 2 ]);
    }
}
