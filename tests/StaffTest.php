<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StaffTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit('/staff')->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/staff')->see('Сотрудники');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager']);

        $this->actingAs($user)->visit('/staff')->dontSee('Сотрудники');
    }

    /**
     * See index staff
     */
    public function testIndexCount()
    {
        $user  = factory(\App\User::class)->create(['job' => 'admin',   'surname' => 'surname1', 'name' => 'name1', 'patronymic' => 'patronymic1', 'username' => 'user1', 'password' => 'password1']);
                 factory(\App\User::class)->create(['job' => 'manager', 'surname' => 'surname2', 'name' => 'name2', 'patronymic' => 'patronymic2', 'username' => 'user2', 'password' => 'password2']);
                 factory(\App\User::class)->create(['job' => 'cook',    'surname' => 'surname3', 'name' => 'name3', 'patronymic' => 'patronymic3', 'username' => 'user3', 'password' => 'password3']);

        $this->actingAs($user)->visit('/staff')
            ->see('Администратор'   )->see('surname1')->see('name1')->see('patronymic1')->see('user1')->see('password1')
            ->see('Менеджер'        )->see('surname2')->see('name2')->see('patronymic2')->see('user2')->see('password2')
            ->see('Повар'           )->see('surname3')->see('name3')->see('patronymic3')->see('user3')->see('password3');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit('/staff/create')->seePageIs('/login');
    }

    /**
     * Create as manager
     */
    public function testCreateAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager']);

        $this->actingAs($user)->visit('/staff/create')->dontSee('Создать сотрудника');
    }

    /**
     * Create as admin
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/staff/create')
            ->see('Создать сотрудника')
            ->type('manager',       'job')
            ->type('surname',       'surname')
            ->type('name',          'name')
            ->type('patronymic',    'patronymic')
            ->type('username',      'username')
            ->type('password',      'password')
            ->type('email@test.ru', 'email')
            ->check('active')
            ->check('work_hours')
            ->press('Сохранить')
            ->seeInDatabase('users', [
                'job'        => 'manager',
                'surname'    => 'surname',
                'name'       => 'name',
                'patronymic' => 'patronymic',
                'username'   => 'username',
                'password'   => 'password',
                'email'      => 'email@test.ru',
                'active'     => 1,
                'work_hours' => 1
            ]);
    }

    /**
     * Create without username and password
     */
    public function testCreateRequired()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/staff/create')
            ->see('Создать сотрудника')
            ->type('manager',       'job')
            ->type('surname',       'surname')
            ->type('name',          'name')
            ->type('patronymic',    'patronymic')
            ->type('email@test.ru', 'email')
            ->check('active')
            ->check('work_hours')
            ->press('Сохранить')
            ->dontSeeInDatabase('users', [
                'job'        => 'manager',
                'surname'    => 'surname',
                'name'       => 'name',
                'patronymic' => 'patronymic',
                'email'      => 'email@test.ru',
                'active'     => 1,
                'work_hours' => 1
            ])
            ->see('Поле username обязательно для заполнения.')
            ->see('Поле password обязательно для заполнения.');
    }

    /**
     * Check active change
     */
    public function testStaffActive()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin', 'active' => 0]);

        $this->actingAs($user)->visit('/staff')
            ->check('active[' . $user->id . ']')
            ->press('Сохранить')
            ->seeInDatabase('users', [
                'id'     => $user->id,
                'active' => 1
            ]);
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);

        $this->visit('/staff/1/edit')->seePageIs('/login');
    }

    /**
     * Create as manager
     */
    public function testUpdateAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);

        $this->actingAs($user)->visit('/staff/1/edit')->dontSee('Редактировать сотрудника');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create([
            'id'         => 2,
            'job'        => 'manager',
            'surname'    => 'surname',
            'name'       => 'name',
            'patronymic' => 'patronymic',
            'username'   => 'username',
            'password'   => 'password',
            'email'      => 'email@test.ru',
            'active'     => 0,
            'work_hours' => 0
        ]);

        $this->actingAs($user)->visit('/staff/2/edit')
            ->see('Редактировать сотрудника')
            ->see('surname')
            ->see('name')
            ->see('patronymic')
            ->see('username')
            ->see('password')
            ->see('email@test.ru')
            ->type('cook',       'job')
            ->type('surname2',       'surname')
            ->type('name2',          'name')
            ->type('patronymic2',    'patronymic')
            ->type('username2',      'username')
            ->type('password2',      'password')
            ->type('email@test.ru2', 'email')
            ->check('active')
            ->check('work_hours')
            ->press('Сохранить')
            ->seeInDatabase('users', [
                'id'         => 2,
                'job'        => 'cook',
                'surname'    => 'surname2',
                'name'       => 'name2',
                'patronymic' => 'patronymic2',
                'username'   => 'username2',
                'password'   => 'password2',
                'email'      => 'email@test.ru2',
                'active'     => 1,
                'work_hours' => 1
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create([
            'id'         => 2,
            'job'        => 'manager',
            'surname'    => 'surname',
            'name'       => 'name',
            'patronymic' => 'patronymic',
            'username'   => 'username',
            'password'   => 'password',
            'email'      => 'email@test.ru',
            'active'     => 0,
            'work_hours' => 0
        ]);

        $this->actingAs($user)->visit('/staff/2/edit')
            ->see('Редактировать сотрудника')
            ->see('surname')
            ->see('name')
            ->see('patronymic')
            ->see('username')
            ->see('password')
            ->see('email@test.ru')
            ->type('',      'username')
            ->type('',      'password')
            ->press('Сохранить')
            ->dontSeeInDatabase('users', [
                'id'       => 2,
                'username' => '',
                'password' => ''
            ])
            ->see('Поле username обязательно для заполнения.')
            ->see('Поле password обязательно для заполнения.');
    }


    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\User::class)->create(['id' => 2]);

        $this->delete('/staff/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager
     */
    public function testDeleteAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\User::class)->create(['id' => 2]);

        $this->actingAs($user)->delete('/staff/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\User::class)->create([
            'id'         => 2,
            'job'        => 'manager',
            'surname'    => 'surname',
            'name'       => 'name',
            'patronymic' => 'patronymic',
            'username'   => 'username',
            'password'   => 'password',
            'email'      => 'email@test.ru',
            'active'     => 0,
            'work_hours' => 0
        ]);

        $this->actingAs($user)->visit('/staff/2/edit')
            ->press('Удалить')
            ->dontSeeInDatabase('users', [ 'id' => 2 ]);
    }

    public function testFullName()
    {
        $user = factory(\App\User::class)->create(['surname' => 'a', 'name' => 'b', 'patronymic' => 'c', 'username' => 'd']);

        $this->assertEquals($user->full_name, "a b c (d)");
    }

    public function testFullNameWithoutSurname()
    {
        $user = factory(\App\User::class)->create(['surname' => null, 'name' => 'b', 'patronymic' => 'c', 'username' => 'd']);

        $this->assertEquals($user->full_name, "b c (d)");
    }

    public function testFullNameWithoutName()
    {
        $user = factory(\App\User::class)->create(['surname' => 'a', 'patronymic' => 'c', 'username' => 'd']);
        $user->name = null;

        $this->assertEquals($user->full_name, "a c (d)");
    }

    public function testFullNameWithoutPatronymic()
    {
        $user = factory(\App\User::class)->create(['surname' => 'a', 'name' => 'b', 'patronymic' => null, 'username' => 'd']);

        $this->assertEquals($user->full_name, "a b (d)");
    }

    public function testFullNameWithoutUsername()
    {
        $user = factory(\App\User::class)->create(['surname' => 'a', 'name' => 'b', 'patronymic' => 'c', 'username' => null]);

        $this->assertEquals($user->full_name, "a b c");
    }

    public function testFullNameEmpty()
    {
        $user = factory(\App\User::class)->create();
        $user->surname    = null;
        $user->name       = null;
        $user->patronymic = null;
        $user->username   = null;

        $this->assertEquals($user->full_name, "");
    }
}