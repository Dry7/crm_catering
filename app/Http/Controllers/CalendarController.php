<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Helpers\DocHelper;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\EventRepository;
use App\Repository\PlaceRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\View;
use PhpOffice\PhpWord\PhpWord;

/**
 * Class CalendarController
 * @package App\Http\Controllers
 */
class CalendarController extends Controller
{
    private $events;

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
        EventRepository $events
    )
    {
        $this->middleware('auth');

        $this->events = $events;
    }

    /**
     * Show all events
     *
     * @return string
     */
    public function index()
    {
        $events = $this->events->with('client')->with('place')->all();

        return view('calendar.index')
            ->with('events', $events);
    }
}