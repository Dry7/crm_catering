<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActiveStaffTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test active manager
     *
     * @return void
     */
    public function testActiveManager()
    {
        factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->see('Клиенты');
    }

    /**
     * Test block manager
     *
     * @return void
     */
    public function testBlockManager()
    {
        factory(\App\User::class)->create(['job' => 'manager', 'active' => 0, 'work_hours' => 0, 'username' => 'username', 'password' => 'password']);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('password', 'password')
            ->press('Войти')
            ->seePageIs('/login?active=1')
            ->see('Вам отказано в доступе. Обратитесь к руководству.');
    }
}
