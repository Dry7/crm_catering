<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\SaveColumnRequest;
use App\Models\Client;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\EventRepository;
use App\Repository\PlaceRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
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

        $this->events  = $events;
        $this->clients = $clients;
        $this->places  = $places;
    }

    /**
     * List statuses
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statuses()
    {
        return response()->json($this->events->getModel()->getStatuses());
    }

    /**
     * List formats
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function formats()
    {
        return response()->json($this->events->getModel()->getFormats());
    }

    /**
     * List clients
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clients()
    {
        return response()->json($this->clients->lists('name', 'id'));
    }

    /**
     * List places
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function places()
    {
        return response()->json($this->places->lists('name', 'id'));
    }

    /**
     * Save attribute
     *
     * @param SaveColumnRequest $request
     */
    public function save(SaveColumnRequest $request)
    {
        $this->events->update([$request->input('name') => $request->input('value')], $request->input('pk'));
    }

    /**
     * Get calendar events
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function events(Request $request)
    {
        $events = $this->events->with('client')->findWhere([
            ['date', '>=', $request->input('start')],
            ['date', '<=', $request->input('end')]]
        )->map(function ($item, $key) {
            return (object)[
                'id' => $item->id,
                'title' => $item->name,
                'start' => $item->date->toDateString(),
                'end' => $item->date->toDateString(),
                'color' => $item->color,
                'url' => route('events.edit', $item->id)
            ];
        });

        return response()->json($events);
    }
}