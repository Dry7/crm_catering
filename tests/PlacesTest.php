<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlacesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Index as guest
     *
     * @return void
     */
    public function testIndexAsGuest()
    {
        $this->visit('/places')->seePageIs('/login');
    }

    /**
     * Index as admin
     */
    public function testIndexAsAdmin()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/places')->see('Места');
    }

    /**
     * Index as manager
     */
    public function testIndexAsManager()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)->visit('/places')->dontSee('Vtcnf')->seePageIs('/');
    }

    /**
     * See index clients as admin
     */
    public function testIndexCountAdmin()
    {
        $user  = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Place::class)->create(['name' => 'name1']);
        factory(\App\Models\Place::class)->create(['name' => 'name2']);
        factory(\App\Models\Place::class)->create(['name' => 'name3']);

        $this->actingAs($user)->visit('/places')
            ->see('name1')
            ->see('name2')
            ->see('name3');
    }

    /**
     * Create as guest
     */
    public function testCreateAsGuest()
    {
        $this->visit('/places/create')->seePageIs('/login');
    }

    /**
     * Create as admin
     */
    public function testCreateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        $this->actingAs($user)->visit('/places/create')
            ->see('Создать место')
            ->type('name',  'name')
            ->press('Сохранить')
            ->seeInDatabase('places', [
                'name'   => 'name'
            ]);
    }

    /**
     * Create without name
     */
    public function testCreateRequired()
    {
        $user = factory(\App\User::class)->create(['job' => 'admin']);

        $this->actingAs($user)->visit('/places/create')
            ->see('Создать место')
            ->press('Сохранить')
            ->see('Поле name обязательно для заполнения.');
    }

    /**
     * Update as guest
     */
    public function testUpdateAsGuest()
    {
        factory(\App\Models\Place::class)->create(['id' => 1]);

        $this->visit('/places/1/edit')->seePageIs('/login');
    }

    /**
     * Update as admin
     */
    public function testUpdateAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Place::class)->create([
            'id'     => 2,
            'name'   => 'name'
        ]);

        $this->actingAs($user)->visit('/places/2/edit')
            ->see('Редактировать место')
            ->see('name')
            ->type('name2', 'name')
            ->press('Сохранить')
            ->seeInDatabase('places', [
                'id'     => 2,
                'name'   => 'name2'
            ]);
    }

    /**
     * Create without username and password
     */
    public function testUpdateRequired()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Place::class)->create([
            'id'     => 2,
            'name'   => 'name'
        ]);

        $this->actingAs($user)->visit('/places/2/edit')
            ->see('Редактировать место')
            ->type('',      'name')
            ->press('Сохранить')
            ->dontSeeInDatabase('places', [
                'id'         => 2,
                'name'       => '',
            ])
            ->see('Поле name обязательно для заполнения.');
    }

    /**
     * Delete as guest
     */
    public function testDeleteAsGuest()
    {
        factory(\App\User::class)->create(['id' => 1, 'job' => 'admin', 'active' => 0]);
        factory(\App\Models\Place::class)->create(['id' => 2]);

        $this->delete('/places/2');
        $this->assertResponseStatus(302);
    }

    /**
     * Delete as manager our
     */
    public function testDeleteAsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'name']);

        $this->actingAs($user)->delete('/places/2');
        $this->assertResponseStatus(302);
        $this->seeInDatabase('places', ['id' => 2]);
    }

    /**
     * Delete as admin
     */
    public function testDeleteAsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Place::class)->create([
            'id'     => 2,
            'name'   => 'name'
        ]);

        $this->actingAs($user)->visit('/places/2/edit')
            ->press('Удалить')
            ->seePageIs('/places')->dontSeeInDatabase('places', [ 'id' => 2 ]);
    }
}