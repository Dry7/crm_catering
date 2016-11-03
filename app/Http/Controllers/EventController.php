<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\EventRepository;
use App\Repository\PlaceRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\View;

/**
 * Class EventsController
 * @package App\Http\Controllers
 */
class EventController extends Controller
{
    private $events;
    private $clients;
    private $places;
    private $products;
    private $categories;
    private $staff;

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     * @param ClientRepository $clients
     * @param PlaceRepository $places
     * @param ProductRepository $products
     * @param CategoryRepository $categories
     * @param UserRepository $staff
     */
    public function __construct(
        EventRepository $events,
        ClientRepository $clients,
        PlaceRepository $places,
        ProductRepository $products,
        CategoryRepository $categories,
        UserRepository $staff
    )
    {
        $this->middleware('auth');

        $this->events = $events;
        $this->clients = $clients;
        $this->places = $places;
        $this->products = $products;
        $this->categories = $categories;
        $this->staff = $staff;
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
            ->with('clients', $this->clients->lists('name', 'id'))
            ->with('places', $this->places->lists('name', 'id'));
    }

    /**
     * Create new event
     *
     * @return string
     */
    public function create()
    {
        $event = new Event(['sections' => json_encode([
            [
                'category' => "",
                'rows' => [
                    ['product' => "", 'amount' => null]
                ]
            ]
        ])]);

        return view('events.create')
            ->with('event', $event)
            ->with('staff', $this->staff->orderBy('surname')->orderBy('name')->orderBy('patronymic')->orderBy('username')->lists('full_name', 'id'))
            ->with('is_admin', \Auth::user()->isAdmin())
            ->with('statuses', $this->events->getModel()->getStatuses())
            ->with('formats', $this->events->getModel()->getFormats())
            ->with('taxes', $this->events->getModel()->getTaxes())
            ->with('templates', $this->events->getModel()->getTemplates())
            ->with('clients', $this->clients->lists('name', 'id'))
            ->with('places', $this->places->lists('name', 'id'))
            ->with('products', $this->products->all())
            ->with('categories', $this->categories->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            $request['user_id'] = \Auth::user()->id;
        }

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

        return view('events.update')
            ->with('event', $event)
            ->with('staff', $this->staff->orderBy('surname')->orderBy('name')->orderBy('patronymic')->orderBy('username')->lists('full_name', 'id'))
            ->with('is_admin', \Auth::user()->isAdmin())
            ->with('statuses', $this->events->getModel()->getStatuses())
            ->with('formats', $this->events->getModel()->getFormats())
            ->with('taxes', $this->events->getModel()->getTaxes())
            ->with('templates', $this->events->getModel()->getTemplates())
            ->with('clients', $this->clients->lists('name', 'id'))
            ->with('places', $this->places->lists('name', 'id'))
            ->with('products', $this->products->all())
            ->with('categories', $this->categories->all());
    }

    /**
     * @param EventRequest $request
     *
     * @param $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse|void
     */
    public function update(EventRequest $request, $id)
    {
        $this->events->update($request->except(['_token']), $id);

        if ($request->has('xls')) {
            return $this->xls($id);
        } elseif ($request->has('word')) {
            return $this->word($id);
        } else {
            return redirect()->route('events.index');
        }
    }

    public function word($id)
    {
        $event = $this->events->find($id);

        $template = 'events.' . $event->template . '.doc';

        if (!View::exists('events.' . $event->template . '.doc')) {
            $template = 'events.default.doc';
        }

        return response()->
            view($template, ['event' => $event, 'sections' => $event->getSectionsList()])
                    ->header('Content-type', 'application/msword;')
                    ->header('Content-Transfer-Encoding', 'Binary')
                    ->header('Content-disposition', 'attachment; filename=test.doc');
    }

    public function xls($id)
    {
        $event = $this->events->find($id);

        echo '<pre>';
        print_r($event->getSectionsList());
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