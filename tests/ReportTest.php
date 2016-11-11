<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ReportTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test last visit staff
     *
     * @return void
     */
    public function testActiveManagerWorkHours()
    {
        Carbon::setTestNow(Carbon::create(2016, 10, 11, 11));

        factory(\App\User::class)->create(['job' => 'manager', 'surname' => null, 'name' => 'name1', 'patronymic' => null, 'username' => 'manager1', 'lastvisit_at' => Carbon::create(2016, 10, 11, 8, 13)]);
        factory(\App\User::class)->create(['job' => 'manager', 'surname' => null, 'name' => 'name2', 'patronymic' => null, 'username' => 'manager2', 'lastvisit_at' => null]);
        factory(\App\User::class)->create(['job' => 'manager', 'surname' => null, 'name' => 'name3', 'patronymic' => null, 'username' => 'manager3', 'lastvisit_at' => Carbon::create(2016, 9, 11, 8, 13)]);
        factory(\App\User::class)->create(['job' => 'manager', 'surname' => null, 'name' => 'name4', 'patronymic' => null, 'username' => 'manager4', 'lastvisit_at' => Carbon::create(2016, 10, 11, 9, 0)]);

        $this->assertEquals([
            (object)['name' => 'name1 (manager1)', 'time' => '10:13'],
            (object)['name' => 'name2 (manager2)', 'time' => 'Не входил'],
            (object)['name' => 'name3 (manager3)', 'time' => 'Не входил'],
            (object)['name' => 'name4 (manager4)', 'time' => '11:00'],
        ], \App\Models\Report::lastVisit());
    }

    /**
     * Test admin emails
     */
    public function testAdminEmails()
    {
        factory(\App\User::class)->create(['job' => 'admin', 'email' => 'email1@example.com']);
        factory(\App\User::class)->create(['job' => 'admin', 'email' => 'email2@example.com']);
        factory(\App\User::class)->create(['job' => 'manager', 'email' => 'email3@example.com']);
        factory(\App\User::class)->create(['job' => 'cook', 'email' => 'email4@example.com']);

        $this->assertEquals([
            'email1@example.com',
            'email2@example.com'
        ], \App\User::getAdminEmails());
    }
}
