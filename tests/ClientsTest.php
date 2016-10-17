<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit('/clients')->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/clients')->see('Клиенты');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit('/clients')->see('Клиенты');
    }

    /**
     * See index clients as manager
     */
    public function testIndexCountManager()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Client::class)->create(['user_id' => 1, 'name' => 'name1', 'phone_work' => 'phone_work1', 'email' => 'email@example.ru1', 'fio' => 'fio1']);
        factory(\App\Models\Client::class)->create(['user_id' => 2, 'name' => 'name2', 'phone_work' => 'phone_work2', 'email' => 'email@example.ru2', 'fio' => 'fio2']);
        factory(\App\Models\Client::class)->create(['user_id' => 3, 'name' => 'name3', 'phone_work' => 'phone_work3', 'email' => 'email@example.ru3', 'fio' => 'fio3']);

        $this->actingAs($user)->visit('/clients')
            ->see('name1')->see('phone_work1')->see('email@example.ru1')->see('fio1')
            ->dontSee('name2')->dontSee('phone_work2')->dontSee('email@example.ru2')->dontSee('fio2')
            ->dontSee('name3')->dontSee('phone_work3')->dontSee('email@example.ru3')->dontSee('fio3');
    }

    /**
     * See index clients as admin
     */
    public function testIndexCountAdmin()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create(['user_id' => 1, 'name' => 'name1', 'phone_work' => 'phone_work1', 'email' => 'email@example.ru1', 'fio' => 'fio1']);
        factory(\App\Models\Client::class)->create(['user_id' => 2, 'name' => 'name2', 'phone_work' => 'phone_work2', 'email' => 'email@example.ru2', 'fio' => 'fio2']);
        factory(\App\Models\Client::class)->create(['user_id' => 3, 'name' => 'name3', 'phone_work' => 'phone_work3', 'email' => 'email@example.ru3', 'fio' => 'fio3']);

        $this->actingAs($user)->visit('/clients')
            ->see('name1')->see('phone_work1')->see('email@example.ru1')->see('fio1')
            ->see('name2')->see('phone_work2')->see('email@example.ru2')->see('fio2')
            ->see('name3')->see('phone_work3')->see('email@example.ru3')->see('fio3');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit('/clients/create')->seePageIs('/login');
    }

    /**
     * Create as admin
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        $this->actingAs($user)->visit('/clients/create')
            ->see('Создать клиента')
            ->type('name',          'name')
            ->type('+7 (999) 999-99-99', 'phone_work')
            ->type('+7 (888) 888-88-88',  'phone_mobile')
            ->type('phone_other',   'phone_other')
            ->type('phone_other2',  'phone_other2')
            ->type('fio',           'fio')
            ->type('job',           'job')
            ->type('16.07.1991',    'birthday')
            ->type('email@test.ru', 'email')
            ->type('events',        'events')
            ->type('site',          'site')
            ->type('address',       'address')
            ->type('description',   'description')
            ->type('hobby',         'hobby')
            ->press('Сохранить')
            ->seeInDatabase('clients', [
                'user_id'      => 1,
                'name'         => 'name',
                'phone_work'   => '+7 (999) 999-99-99',
                'phone_mobile' => '+7 (888) 888-88-88',
                'phone_other'  => 'phone_other',
                'phone_other2' => 'phone_other2',
                'fio'          => 'fio',
                'job'          => 'job',
                'email'        => 'email@test.ru',
                'events'       => 'events',
                'site'         => 'site',
                'address'      => 'address',
                'description'  => 'description',
                'hobby'        => 'hobby'
            ]);
    }

    /**
     * Create without username and password
     */
    public function testCreateRequired()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/clients/create')
            ->see('Создать клиента')
            ->type('phone_mobile', 'phone_mobile')
            ->type('phone_other',  'phone_other')
            ->type('phone_other2', 'phone_other2')
            ->type('16.07.1991',   'birthday')
            ->type('events',       'events')
            ->type('site',         'site')
            ->type('address',      'address')
            ->type('description',  'description')
            ->type('hobby',        'hobby')
            ->press('Сохранить')
            ->dontSeeInDatabase('clients', [
                'phone_mobile' => 'phone_mobile',
                'phone_other'  => 'phone_other',
                'phone_other2' => 'phone_other2',
                'events'       => 'events',
                'site'         => 'site',
                'address'      => 'address',
                'description'  => 'description',
                'hobby'        => 'hobby'
            ])
            ->see('Поле name обязательно для заполнения.')
            ->see('Поле phone work обязательно для заполнения.')
            ->see('Поле fio обязательно для заполнения.')
            ->see('Поле job обязательно для заполнения.')
            ->see('Поле email обязательно для заполнения.');
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'name1', 'phone_work' => 'phone_work1', 'email' => 'email@example.ru1', 'fio' => 'fio1']);

        $this->visit('/clients/1/edit')->seePageIs('/login');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create([
            'id'           => 2,
            'user_id'      => 1,
            'name'         => 'name',
            'phone_work'   => 'phone_work',
            'phone_mobile' => 'phone_mobile',
            'phone_other'  => 'phone_other',
            'phone_other2' => 'phone_other2',
            'fio'          => 'fio',
            'job'          => 'job',
            'birthday'     => '16.07.1991',
            'email'        => 'email@test.ru',
            'events'       => 'events',
            'site'         => 'site',
            'address'      => 'address',
            'description'  => 'description',
            'hobby'        => 'hobby'
        ]);

        $this->actingAs($user)->visit('/clients/2/edit')
            ->see('Редактировать клиента')
            ->see('name')
            ->see('phone_work')
            ->see('phone_mobile')
            ->see('phone_other')
            ->see('phone_other2')
            ->see('fio')
            ->see('job')
            ->see('16.07.1991')
            ->see('email@test.ru')
            ->see('events')
            ->see('site')
            ->see('address')
            ->see('description')
            ->see('hobby')
            ->type('name2',          'name')
            ->type('phone_work2',    'phone_work')
            ->type('phone_mobile2',  'phone_mobile')
            ->type('phone_other',    'phone_other')
            ->type('phone_other2',   'phone_other2')
            ->type('fio2',           'fio')
            ->type('job2',           'job')
            ->type('17.07.1991',     'birthday')
            ->type('email@test.ru2', 'email')
            ->type('events2',        'events')
            ->type('site2',          'site')
            ->type('address2',       'address')
            ->type('description2',   'description')
            ->type('hobby2',         'hobby')
            ->press('Сохранить')
            ->seeInDatabase('clients', [
                'id'           => 2,
                'user_id'      => 1,
                'name'         => 'name2',
                'phone_work'   => 'phone_work2',
                'phone_mobile' => 'phone_mobile2',
                'phone_other'  => 'phone_other',
                'phone_other2' => 'phone_other2',
                'fio'          => 'fio2',
                'job'          => 'job2',
                'email'        => 'email@test.ru2',
                'events'       => 'events2',
                'site'         => 'site2',
                'address'      => 'address2',
                'description'  => 'description2',
                'hobby'        => 'hobby2'
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create([
            'id'           => 2,
            'user_id'      => 1,
            'name'         => 'name',
            'phone_work'   => 'phone_work',
            'phone_mobile' => 'phone_mobile',
            'phone_other'  => 'phone_other',
            'phone_other2' => 'phone_other2',
            'fio'          => 'fio',
            'job'          => 'job',
            'birthday'     => '16.07.1991',
            'email'        => 'email@test.ru',
            'events'       => 'events',
            'site'         => 'site',
            'address'      => 'address',
            'description'  => 'description',
            'hobby'        => 'hobby'
        ]);

        $this->actingAs($user)->visit('/clients/2/edit')
            ->see('Редактировать клиента')
            ->type('',      'name')
            ->type('',      'phone_work')
            ->type('',      'fio')
            ->type('',      'job')
            ->type('',      'email')
            ->press('Сохранить')
            ->dontSeeInDatabase('clients', [
                'id'         => 2,
                'name'       => '',
                'phone_work' => '',
                'fio'        => '',
                'job'        => '',
                'email'      => ''
            ])
            ->see('Поле name обязательно для заполнения.')
            ->see('Поле phone work обязательно для заполнения.')
            ->see('Поле fio обязательно для заполнения.')
            ->see('Поле job обязательно для заполнения.')
            ->see('Поле email обязательно для заполнения.');
    }


    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\Models\Client::class)->create(['id' => 2]);

        $this->delete('/clients/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManagerOur()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'user_id' => 1]);

        $this->actingAs($user)->delete('/clients/2');
        $this->dontSeeInDatabase('clients', ['id' => 2]);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManager2()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'user_id' => 2]);

        $this->actingAs($user)->delete('/clients/2');
        $this->seeInDatabase('clients', ['id' => 2]);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create([
            'id'           => 2,
            'user_id'      => 2,
            'name'         => 'name',
            'phone_work'   => 'phone_work',
            'phone_mobile' => 'phone_mobile',
            'phone_other'  => 'phone_other',
            'phone_other2' => 'phone_other2',
            'fio'          => 'fio',
            'job'          => 'job',
            'birthday'     => '16.07.1991',
            'email'        => 'email@test.ru',
            'events'       => 'events',
            'site'         => 'site',
            'address'      => 'address',
            'description'  => 'description',
            'hobby'        => 'hobby'
        ]);

        $this->actingAs($user)->visit('/clients/2/edit')
            ->press('Удалить')
            ->dontSeeInDatabase('clients', [ 'id' => 2 ]);
    }
}