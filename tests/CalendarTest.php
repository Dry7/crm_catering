<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CalendarTest extends TestCase
{
    use DatabaseMigrations;

    private $url   = '/calendar';
    private $table = 'calendar';

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

        $this->actingAs($user)->visit($this->url)->see('Календарь проектов')->see('Добавить мероприятие');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit($this->url)->see('Календарь проектов')->see('Добавить мероприятие');
    }
}