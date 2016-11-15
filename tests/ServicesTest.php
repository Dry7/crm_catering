<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ServicesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit('/services')->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/services')->see('Услуги');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit('/services')->dontSee('Услуги')->seePageIs('/calendar');
    }

    /**
     * See index clients as admin
     */
    public function testIndexCountAdmin()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Service::class)->create(['name' => 'name1', 'weight' => null, 'price' => 100]);
        factory(\App\Models\Service::class)->create(['name' => 'name2', 'weight' => null, 'price' => 200.10]);
        factory(\App\Models\Service::class)->create(['name' => 'name3', 'weight' => null, 'price' => 23000]);

        $this->actingAs($user)->visit('/services')
            ->see('name1')->see('100.00 р.')
            ->see('name2')->see('200.10 р.')
            ->see('name3')->see('23 000.00 р.');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit('/services/create')->seePageIs('/login');
    }

    /**
     * Create as admin
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        $this->actingAs($user)->visit('/services/create')
            ->see('Создать услугу')
            ->type('name',  'name')
            ->type('100',   'weight')
            ->type('12345', 'price')
            ->press('Сохранить')
            ->seeInDatabase('services', [
                'name'   => 'name',
                'weight' => '100',
                'price'  => '12345'
            ]);
    }

    /**
     * Create without name
     */
    public function testCreateRequired()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/services/create')
            ->see('Создать услугу')
            ->type('200', 'weight')
            ->type('100', 'price')
            ->press('Сохранить')
            ->dontSeeInDatabase('clients', [
                'weight' => '200',
                'price'  => '100'
            ])
            ->see('Поле name обязательно для заполнения.');
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\Models\Service::class)->create(['id' => 1, 'name' => 'name1', 'weight' => 100, 'price' => 200]);

        $this->visit('/services/1/edit')->seePageIs('/login');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Service::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20
        ]);

        $this->actingAs($user)->visit('/services/2/edit')
            ->see('Редактировать услугу')
            ->see('name')
            ->see('403')
            ->see('10000.2')
            ->type('name2', 'name')
            ->type('305',   'weight')
            ->type('12',    'price')
            ->press('Сохранить')
            ->seeInDatabase('services', [
                'id'     => 2,
                'name'   => 'name2',
                'weight' => '305',
                'price'  => '12'
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Service::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20
        ]);

        $this->actingAs($user)->visit('/services/2/edit')
            ->see('Редактировать услугу')
            ->type('',      'name')
            ->press('Сохранить')
            ->dontSeeInDatabase('clients', [
                'id'         => 2,
                'name'       => '',
                'phone_work' => '',
                'fio'        => '',
                'job'        => '',
                'email'      => ''
            ])
            ->see('Поле name обязательно для заполнения.');
    }

    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\Models\Service::class)->create(['id' => 2]);

        $this->delete('/services/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\Models\Service::class)->create(['id' => 2, 'name' => 'name']);

        $this->actingAs($user)->delete('/services/2');
        $this->assertResponseStatus(302);
        $this->seeInDatabase('services', ['id' => 2]);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Service::class)->create([
            'id'     => 2,
            'name'   => 'name',
            'weight' => 403,
            'price'  => 10000.20
        ]);

        $this->actingAs($user)->visit('/services/2/edit')
            ->press('Удалить')
            ->seePageIs('/services')->dontSeeInDatabase('services', [ 'id' => 2 ]);
    }
}