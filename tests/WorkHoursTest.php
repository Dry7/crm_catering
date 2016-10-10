<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class WorkHoursTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test active manager work hours
     *
     * @return void
     */
    public function testActiveManagerWorkHours()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 11, 16));

        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 1, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->see('Клиенты');
    }

    /**
     * Test active manager work hours morning
     *
     * @return void
     */
    public function testActiveManagerWorkHoursMorning()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 11, 7));

        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 1, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->dontSee('Клиенты')
            ->seePageIs('/login?work_hours=1')
            ->see('Вы можете работать с системой только в рабочее время.');
    }

    /**
     * Test active manager work hours evening
     *
     * @return void
     */
    public function testActiveManagerWorkHoursEvening()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 11, 19));

        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 1, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->dontSee('Клиенты')
            ->seePageIs('/login?work_hours=1')
            ->see('Вы можете работать с системой только в рабочее время.');
    }

    /**
     * Test active manager work hours saturday
     *
     * @return void
     */
    public function testActiveManagerWorkHoursSaturday()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 8, 7));

        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 1, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->dontSee('Клиенты')
            ->seePageIs('/login?work_hours=1')
            ->see('Вы можете работать с системой только в рабочее время.');
    }

    /**
     * Test active manager work hours sunday
     *
     * @return void
     */
    public function testActiveManagerWorkHoursSunday()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 9, 14));

        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 1, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->dontSee('Клиенты')
            ->seePageIs('/login?work_hours=1')
            ->see('Вы можете работать с системой только в рабочее время.');
    }
}
