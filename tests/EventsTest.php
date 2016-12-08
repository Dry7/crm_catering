<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventsTest extends TestCase
{
    use DatabaseMigrations;

    private $url   = '/events';
    private $table = 'events';

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit($this->url)->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit($this->url)->see('Мероприятия');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit($this->url)->see('Мероприятия');
    }

    /**
     * See index clients as admin
     */
    public function testIndexCountAdmin()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        factory(\App\Models\Event::class)->create([
            'status_id' => 1, 'client_id' => 1, 'date' => '01.01.2016', 'format_id' => 1, 'persons' => 10, 'tables' => 15, 'place_id' => 1
        ]);
        factory(\App\Models\Event::class)->create([
            'status_id' => 2, 'client_id' => 2, 'date' => '20.10.2016', 'format_id' => 2, 'persons' => 20, 'tables' => 25, 'place_id' => 2
        ]);
        factory(\App\Models\Event::class)->create([
            'status_id' => 3, 'client_id' => 3, 'date' => '25.10.2016', 'format_id' => 3, 'persons' => 30, 'tables' => 35, 'place_id' => 3
        ]);

        $this->actingAs($user)->visit($this->url)
            ->see('Черновик')->see('client1')->see('01.01.2016')->see('Банкет')->see(10)->see(15)->see('place1')
            ->see('Выслано КП')->see('client2')->see('20.10.2016')->see('Фуршет')->see(20)->see(25)->see('place2')
            ->see('Утвержден')->see('client3')->see('25.10.2016')->see('Кофе-брейк')->see(30)->see(35)->see('place3');
    }

    /**
     * See index clients as manager
     */
    public function testIndexCountManager()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        factory(\App\Models\Event::class)->create([
            'user_id' => 1, 'status_id' => 1, 'client_id' => 1, 'date' => '01.01.2016', 'format_id' => 1, 'persons' => 10, 'tables' => 15, 'place_id' => 1
        ]);
        factory(\App\Models\Event::class)->create([
            'user_id' => 1, 'status_id' => 2, 'client_id' => 2, 'date' => '20.10.2016', 'format_id' => 2, 'persons' => 20, 'tables' => 25, 'place_id' => 2
        ]);
        factory(\App\Models\Event::class)->create([
            'user_id' => 2, 'status_id' => 3, 'client_id' => 3, 'date' => '25.10.2016', 'format_id' => 3, 'persons' => 30, 'tables' => 35, 'place_id' => 3
        ]);
        factory(\App\Models\Event::class)->create([
            'user_id' => 2, 'status_id' => 3, 'client_id' => 3, 'date' => '26.10.2016', 'format_id' => 3, 'persons' => 30, 'tables' => 35, 'place_id' => 3
        ]);
        factory(\App\Models\Event::class)->create([
            'user_id' => 2, 'status_id' => 3, 'client_id' => 3, 'date' => '27.10.2016', 'format_id' => 3, 'persons' => 30, 'tables' => 35, 'place_id' => 3
        ]);

        $this->actingAs($user)->visit($this->url)
            ->see('Черновик</a>')->see('client1</a>')->see('01.01.2016')->see('Банкет</a>')->see('10</a>')->see('15</a>')->see('place1</a>')
            ->see('Выслано КП</a>')->see('client2</a>')->see('20.10.2016')->see('Фуршет</a>')->see('20</a>')->see('25</a>')->see('place2</a>')
            ->dontSee('Утвержден</a>')->dontSee('client3')->dontSee('25.10.2016')->dontSee('Кофе-брейк</a>')->dontSee('30</a>')->dontSee('35</a>')->dontSee('place3</a>')
            ->dontSee('26.10.2016')->dontSee('27.10.2016');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit($this->url . '/create')->seePageIs('/login');
    }

    /**
     * Create as manager
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create(['id' => 2, 'name' => 'manager1', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'name' => 'manager2', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 4, 'name' => 'manager3', 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        $this->actingAs($user)->visit($this->url . '/create')
            ->see('Создать мероприятие')
            ->type(1,            'user_id')
            ->type(2,            'status_id')
            ->type(3,            'client_id')
            ->type('25.10.2016', 'date')
            ->type(3,            'format_id')
            ->type(10,           'persons')
            ->type(20,           'tables')
            ->type(30,           'staff')
            ->type(2,            'place_id')
            ->type('10:10',      'meeting')
            ->type('11:11',      'main')
            ->type('12:12',      'hot_snacks')
            ->type('13:13',      'sorbet')
            ->type('14:14',      'hot')
            ->type('15:15',      'dessert')
            ->press('СохранитьUnit')
            ->seeInDatabase($this->table, [
                'user_id'    => 1,
                'status_id'  => 2,
                'client_id'  => 3,
                'format_id'  => 3,
                'persons'    => 10,
                'tables'     => 20,
                'staff'      => 30,
                'place_id'   => 2,
                'meeting'    => '10:10',
                'main'       => '11:11',
                'hot_snacks' => '12:12',
                'sorbet'     => '13:13',
                'hot'        => '14:14',
                'dessert'    => '15:15'
            ]);
    }

    /**
     * Create as manager
     */
    public function testCreateAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 10, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);
        factory(\App\User::class, 10)->create();

        factory(\App\User::class)->create(['id' => 1, 'name' => 'manager1', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 2, 'name' => 'manager2', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'name' => 'manager3', 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'user_id' => 10]);
        factory(\App\Models\Client::class)->create(['id' => 2, 'user_id' => 10]);
        factory(\App\Models\Client::class)->create(['id' => 3, 'user_id' => 10]);
        factory(\App\Models\Client::class)->create(['id' => 4, 'user_id' => 10]);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        $this->actingAs($user)->visit($this->url . '/create')
            ->see('Создать мероприятие')
            ->type(2,            'status_id')
            ->type(3,            'client_id')
            ->type('25.10.2016', 'date')
            ->type(3,            'format_id')
            ->type(10,           'persons')
            ->type(20,           'tables')
            ->type(30,           'staff')
            ->type(2,            'place_id')
            ->type('10:10',      'meeting')
            ->type('11:11',      'main')
            ->type('12:12',      'hot_snacks')
            ->type('13:13',      'sorbet')
            ->type('14:14',      'hot')
            ->type('15:15',      'dessert')
            ->press('СохранитьUnit')
            ->seeInDatabase($this->table, [
                'user_id'    => 10,
                'status_id'  => 2,
                'client_id'  => 3,
                'format_id'  => 3,
                'persons'    => 10,
                'tables'     => 20,
                'staff'      => 30,
                'place_id'   => 2,
                'meeting'    => '10:10',
                'main'       => '11:11',
                'hot_snacks' => '12:12',
                'sorbet'     => '13:13',
                'hot'        => '14:14',
                'dessert'    => '15:15'
            ]);
    }

    /**
     * Create only required fields
     */
    public function testCreateOnlyRequiredFields()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create(['id' => 2, 'name' => 'manager1', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'name' => 'manager2', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 4, 'name' => 'manager3', 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        $this->actingAs($user)->visit($this->url . '/create')
            ->see('Создать мероприятие')
            ->type(1,            'user_id')
            ->type(2,            'status_id')
            ->type(3,            'client_id')
            ->type('25.10.2016', 'date')
            ->type(3,            'format_id')
            ->press('СохранитьUnit')
            ->seeInDatabase($this->table, [
                'user_id'    => 1,
                'status_id'  => 2,
                'client_id'  => 3,
                'format_id'  => 3
            ]);
    }

    /**
     * Create withour required fields
     */
    public function testCreateWithoutRequiredFields()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create(['id' => 2, 'name' => 'manager1', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'name' => 'manager2', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 4, 'name' => 'manager3', 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        $this->actingAs($user)->visit($this->url . '/create')
            ->see('Создать мероприятие')
            ->type(10,           'persons')
            ->type(20,           'tables')
            ->type(30,           'staff')
            ->type(2,            'place_id')
            ->type('10:10',      'meeting')
            ->type('11:11',      'main')
            ->type('12:12',      'hot_snacks')
            ->type('13:13',      'sorbet')
            ->type('14:14',      'hot')
            ->type('15:15',      'dessert')
            ->press('СохранитьUnit')
            ->dontSeeInDatabase($this->table, [
                'persons'    => 10,
                'tables'     => 20,
                'staff'      => 30,
                'place_id'   => 2,
                'meeting'    => '10:10:00',
                'main'       => '11:11:00',
                'hot_snacks' => '12:12:00',
                'sorbet'     => '13:13:00',
                'hot'        => '14:14:00',
                'dessert'    => '15:15:00'
            ])
            ->see('Поле status id обязательно для заполнения.');
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\Models\Event::class)->create(['id' => 1]);

        $this->visit($this->url . '/1/edit')->seePageIs('/login');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create(['id' => 2, 'name' => 'manager1', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'name' => 'manager2', 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 4, 'name' => 'manager3', 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        factory(\App\Models\Event::class)->create([
            'id'         => 2,
            'user_id'    => 1,
            'status_id'  => 2,
            'client_id'  => 3,
            'date'       => '25.10.2016',
            'format_id'  => 3,
            'persons'    => 10,
            'tables'     => 20,
            'staff'      => 30,
            'place_id'   => 2,
            'meeting'    => '10:10:00',
            'main'       => '11:11:00',
            'hot_snacks' => '12:12:00',
            'sorbet'     => '13:13:00',
            'hot'        => '14:14:00',
            'dessert'    => '15:15:00'
        ]);

        $this->actingAs($user)->visit($this->url . '/2/edit')
            ->see('Редактировать мероприятие')
            ->see('25.10.2016')
            ->see('10')
            ->see('20')
            ->see('30')
            ->see('10:10')
            ->see('11:11')
            ->see('12:12')
            ->see('13:13')
            ->see('14:14')
            ->see('15:15')
            ->type(1,            'status_id')
            ->type(1,            'client_id')
            ->type('26.10.2016', 'date')
            ->type(1,            'format_id')
            ->type(2,           'persons')
            ->type(3,           'tables')
            ->type(4,           'staff')
            ->type(3,            'place_id')
            ->type('00:10',      'meeting')
            ->type('01:11',      'main')
            ->type('02:12',      'hot_snacks')
            ->type('03:13',      'sorbet')
            ->type('04:14',      'hot')
            ->type('05:15',      'dessert')
            ->press('СохранитьUnit')
            ->seeInDatabase($this->table, [
                'id'         => 2,
                'status_id'  => 1,
                'client_id'  => 1,
                'format_id'  => 1,
                'persons'    => 2,
                'tables'     => 3,
                'staff'      => 4,
                'place_id'   => 3,
                'meeting'    => '00:10',
                'main'       => '01:11',
                'hot_snacks' => '02:12',
                'sorbet'     => '03:13',
                'hot'        => '04:14',
                'dessert'    => '05:15'
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create(['id' => 2, 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 3, 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 4, 'job' => 'manager']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['id' => 3, 'name' => 'client3']);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        factory(\App\Models\Event::class)->create([
            'id'         => 2,
            'user_id'    => 1,
            'status_id'  => 2,
            'client_id'  => 3,
            'date'       => '25.10.2016',
            'format_id'  => 3,
            'persons'    => 10,
            'tables'     => 20,
            'staff'      => 30,
            'place_id'   => 2,
            'meeting'    => '10:10',
            'main'       => '11:11',
            'hot_snacks' => '12:12',
            'sorbet'     => '13:13',
            'hot'        => '14:14',
            'dessert'    => '15:15'
        ]);

        $this->actingAs($user)->visit($this->url . '/2/edit')
            ->see('Редактировать мероприятие')
            ->type('', 'status_id')
            ->type('', 'client_id')
            ->type('', 'date')
            ->type('', 'format_id')
            ->press('СохранитьUnit')
            ->dontSeeInDatabase($this->table, [
                'id'        => 2,
                'status_id' => '',
                'client_id' => '',
                'date'      => '',
                'format_id' => ''
            ])
            ->see('Поле status id обязательно для заполнения.');
    }

    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\Models\Event::class)->create(['id' => 2]);

        $this->delete($this->url . '/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManagerOur()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Event::class)->create([ 'id' => 2, 'user_id' => 1]);

        $this->actingAs($user)->visit($this->url . '/2/edit')
            ->press('Удалить')
            ->seePageIs($this->url)->dontSeeInDatabase($this->table, [ 'id' => 2 ]);
    }

    /**
     * Delete as manager foreign
     */
    public function testDeleteAsManagerForeign()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);
        factory(\App\Models\Event::class)->create(['id' => 2, 'user_id' => 2]);

        $this->actingAs($user)->delete($this->url . '/2');
        $this->assertResponseStatus(404);
        $this->seeInDatabase($this->table, ['id' => 2]);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Event::class)->create(['id' => 2]);

        $this->actingAs($user)->visit($this->url . '/2/edit')
            ->press('Удалить')
            ->seePageIs($this->url)->dontSeeInDatabase($this->table, [ 'id' => 2 ]);
    }
}