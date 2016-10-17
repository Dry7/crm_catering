<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Models\Event;
use App\Repository\ClientRepository;
use App\Repository\EventRepository;
use App\Repository\PlaceRepository;

/**
 * Class EventsController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{
    private $events;
    private $clients;
    private $places;

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     * @param ClientRepository $clients
     * @param PlaceRepository $places
     */
    public function __construct(EventRepository $events, ClientRepository $clients, PlaceRepository $places)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->events = $events;
        $this->clients = $clients;
        $this->places = $places;
    }

    /**
     * Show all events
     *
     * @return string
     */
    public function index()
    {
        $events = $this->events->with('client')->with('place')->all();

        return view('events.index')
            ->with('events', $events)
            ->with('statuses', $this->events->getModel()->getStatuses())
            ->with('formats', $this->events->getModel()->getFormats())
            ->with('clients', $this->clients->lists('name'))
            ->with('places', $this->places->lists('name'))
            ;
    }

    /**
     * Create new event
     *
     * @return string
     */
    public function create()
    {
        $event = new Event();

        return view('events.create')->with('event', $event);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventRepository  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventRepository $request)
    {
        $this->events->create($request->except(['_token']));

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update event
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $event = $this->events->find($id);

        return view('events.update')->with('event', $event);
    }

    /**
     * Save user
     *
     * @param EventRepository $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventRepository $request, $id)
    {
        $this->events->update($request->except(['_token']), $id);

        return redirect()->route('events.index');
    }

    /**
     * Remove event
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->events->delete($id);

        return redirect()->route('events.index');
    }
}