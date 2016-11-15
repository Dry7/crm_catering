<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogTest extends TestCase
{
    use DatabaseMigrations;

    private $url   = '/log';
    private $table = 'logging';

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

        $this->actingAs($user)->visit($this->url)->see('Действия менеджеров');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit($this->url)->dontSee('Действия менеджеров');
    }

    /**
     * See index staff
     */
    public function testIndexCount()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);
        $user2 = factory(\App\User::class)->create(['id' => 2, 'job' => 'manager', 'active' => 1, 'work_hours' => 0, 'name' => 'name', 'surname' => 'surname', 'patronymic' => 'patronymic', 'username' => 'username']);

        factory(\App\Models\Log::class)->create(['user_id' => 2, 'event' => 'clients.index',  'element_name' => null]);
        factory(\App\Models\Log::class)->create(['user_id' => 2, 'event' => 'events.edit',    'element_name' => 'element_name']);
        factory(\App\Models\Log::class)->create(['user_id' => 2, 'event' => 'calendar.index', 'element_name' => null]);

        $this->actingAs($user)->visit($this->url)
            ->see($user2->full_name)->see('Просмотр списка клиентов')
            ->see($user2->full_name)->see('Просмотр мероприятия')->see('element_name')
            ->see($user2->full_name)->see('Календарь мероприятий');
    }

    /**
     * Check log
     */
    public function testCreateAsGuest()
    {
        $user = factory(\App\User::class)->create(['id' => 2, 'job' => 'manager', 'active' => 1, 'work_hours' => 0, 'name' => 'name', 'surname' => 'surname', 'patronymic' => 'patronymic', 'username' => 'username']);

        $this->actingAs($user)->visit('/clients')->seeInDatabase('logging', [
            'user_id' => 2,
            'event' => 'clients.index'
        ]);
    }
}