<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiTests extends TestCase
{
    use DatabaseMigrations;

    private $url = '/api/v1';

    /**
     * /api/v1/events/statuses
     *
     * @return void
     */
    public function testEventsStatuses()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $event = new \App\Models\Event();

        $response = $this->actingAs($user)->visit($this->url . '/events/statuses')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode($event->getStatuses()));
    }

    /**
     * /api/v1/events/formats
     *
     * @return void
     */
    public function testEventsFormats()
    {
        $user = factory(\App\User::class)->create(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        $event = new \App\Models\Event();

        $response = $this->actingAs($user)->visit($this->url . '/events/formats')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode($event->getFormats()));
    }

    /**
     * /api/v1/events/clients
     *
     * @return void
     */
    public function testEventsClients()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Client::class)->create(['user_id' => 1, 'id' => 1, 'name' => 'client1']);
        factory(\App\Models\Client::class)->create(['user_id' => 1, 'id' => 2, 'name' => 'client2']);
        factory(\App\Models\Client::class)->create(['user_id' => 1, 'id' => 3, 'name' => 'client3']);

        $response = $this->actingAs($user)->visit($this->url . '/events/clients')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode([
            '1' => 'client1',
            '2' => 'client2',
            '3' => 'client3'
        ]));
    }

    /**
     * /api/v1/events/places
     *
     * @return void
     */
    public function testEventsPlaces()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place1']);
        factory(\App\Models\Place::class)->create(['id' => 2, 'name' => 'place2']);
        factory(\App\Models\Place::class)->create(['id' => 3, 'name' => 'place3']);

        $response = $this->actingAs($user)->visit($this->url . '/events/places')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode([
            '1' => 'place1',
            '2' => 'place2',
            '3' => 'place3'
        ]));
    }

    /**
     * /api/v1/events/save as manager
     *
     * @return void
     */
    public function testEventsSaveManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Event::class)->create(['id' => 1, 'user_id' => 1, 'status_id' => 1]);

        $this->actingAs($user)->post($this->url . '/events/save', [
            'pk' => 1,
            'name' => 'status_id',
            'value' => 2
        ]);

        $this->seeInDatabase('events', [
            'id' => 1,
            'status_id' => 2
        ]);
    }

    /**
     * /api/v1/events/save as manager foreign
     *
     * @return void
     */
    public function testEventsSaveManagerForeign()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Event::class)->create(['id' => 1, 'user_id' => 2, 'status_id' => 1]);

        $this->actingAs($user)->post($this->url . '/events/save', [
            'pk' => 1,
            'name' => 'status_id',
            'value' => 2
        ]);

        $this->dontSeeInDatabase('events', [
            'id' => 1,
            'status_id' => 2
        ]);
    }

    /**
     * /api/v1/events/save as manager foreign
     *
     * @return void
     */
    public function testEventsSaveAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Event::class)->create(['id' => 1, 'user_id' => 2, 'status_id' => 1]);

        $this->actingAs($user)->post($this->url . '/events/save', [
            'pk' => 1,
            'name' => 'status_id',
            'value' => 2
        ]);

        $this->seeInDatabase('events', [
            'id' => 1,
            'status_id' => 2
        ]);
    }

    /**
     * /api/v1/calendar/events as admin
     *
     * @return void
     */
    public function testCalendarEventsAdmin()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'admin']);

        factory(\App\Models\Client::class)->create(['id' => 1, 'user_id' => 1, 'name' => 'client']);
        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place']);

        $event1 = factory(\App\Models\Event::class)->create(['id' => 1, 'user_id' => 1, 'date' => '01.10.2016']);
        $event2 = factory(\App\Models\Event::class)->create(['id' => 2, 'user_id' => 2, 'date' => '02.11.2016']);
        $event3 = factory(\App\Models\Event::class)->create(['id' => 3, 'user_id' => 2, 'date' => '05.11.2016']);
        $event4 = factory(\App\Models\Event::class)->create(['id' => 4, 'user_id' => 2, 'date' => '05.12.2016']);

        $response = $this->actingAs($user)->get($this->url . '/calendar/events?start=2016-11-01&end=2016-11-30')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode([
            [
                'id' => $event2->id,
                'title' => $event2->name,
                'start' => $event2->date->toDateString(),
                'end' => $event2->date->toDateString(),
                'color' => $event2->color,
                'url' => route('events.edit', $event2->id)
            ],
            [
                'id' => $event3->id,
                'title' => $event3->name,
                'start' => $event3->date->toDateString(),
                'end' => $event3->date->toDateString(),
                'color' => $event3->color,
                'url' => route('events.edit', $event3->id)
            ]
        ]));
    }


    /**
     * /api/v1/calendar/events as manager
     *
     * @return void
     */
    public function testCalendarEventsManager()
    {
        $user = factory(\App\User::class)->create(['id' => 1, 'job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        factory(\App\Models\Client::class)->create(['id' => 1, 'user_id' => 1, 'name' => 'client']);
        factory(\App\Models\Place::class)->create(['id' => 1, 'name' => 'place']);

        $event1 = factory(\App\Models\Event::class)->create(['id' => 1, 'user_id' => 1, 'date' => '01.10.2016']);
        $event2 = factory(\App\Models\Event::class)->create(['id' => 2, 'user_id' => 2, 'date' => '02.11.2016']);
        $event3 = factory(\App\Models\Event::class)->create(['id' => 3, 'user_id' => 1, 'date' => '05.11.2016']);
        $event4 = factory(\App\Models\Event::class)->create(['id' => 4, 'user_id' => 2, 'date' => '05.12.2016']);
        $event5 = factory(\App\Models\Event::class)->create(['id' => 5, 'user_id' => 1, 'date' => '05.12.2016']);

        $response = $this->actingAs($user)->get($this->url . '/calendar/events?start=2016-11-01&end=2016-11-30')->response->getContent();

        $this->assertJsonStringEqualsJsonString($response, json_encode([
            [
                'id' => $event3->id,
                'title' => $event3->name,
                'start' => $event3->date->toDateString(),
                'end' => $event3->date->toDateString(),
                'color' => $event3->color,
                'url' => route('events.edit', $event3->id)
            ]
        ]));
    }
}