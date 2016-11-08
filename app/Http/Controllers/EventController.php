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
            ->with('max_discount', \Auth::user()->max_discount)
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
            ->with('max_discount', \Auth::user()->max_discount)
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

        if ($request->exists('xls')) {
            return $this->xls($id);
        } elseif ($request->exists('word')) {
            return $this->word($id);
        } elseif ($request->exists('pdf')) {
            return $this->pdf($id);
        } else {
            return redirect()->route('events.index');
        }
    }

    /**
     * Download event in Microsoft Word format
     *
     * @param $id
     *
     * @return Response
     */
    public function word($id)
    {
        $event = $this->events->find($id);

        $template = 'events.' . $event->template . '.doc';

        if (!View::exists('events.' . $event->template . '.doc')) {
            $template = 'events.default.doc';
        }

        return response()->
                    view($template, [
                        'event' => $event,
                        'sections' => $event->getSectionsList(),
                        'copyright' => Auth::user()->copyright,
                        'total' => $event->weight_person ? $event->getTotal(true) : $event->getTotal()
                    ])
                    ->header('Content-type', 'application/msword;')
                    ->header('Content-Transfer-Encoding', 'Binary')
                    ->header('Content-disposition', 'attachment; filename="' . $event->name . '.doc"');
    }

    /**
     * Download event in PDF format
     *
     * @param $id
     *
     * @return Response
     */
    public function pdf($id)
    {
        $event = $this->events->find($id);

        $template = 'events.' . $event->template . '.pdf';

        if (!View::exists('events.' . $event->template . '.pdf')) {
            $template = 'events.default.pdf';
        }

        return PDF::loadView($template, [
            'event' => $event,
            'sections' => $event->getSectionsList(),
            'copyright' => Auth::user()->copyright,
            'total' => $event->weight_person ? $event->getTotal(true) : $event->getTotal()
        ])->download($event->name . '.pdf');
    }

    /**
     * Download event in Microsoft Excel format
     *
     * @param $id
     *
     * @return Response
     */
    public function xls($id)
    {
        $event = $this->events->find($id);
        $sections = $event->getSectionsList();

        Excel::create($event->name . '.xls', function ($excel) use ($event, $sections){
            $excel->sheet('Меню', function($sheet) use ($event, $sections) {

                $time_index = 2;

                $sheet->cell('H' . $time_index++, function ($cell) { $cell->setValue('Информация о мероприятии'); $cell->setFontWeight('bold'); });

                $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Дата'); });
                $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->date->format('d.m.Y')); });

                if ($event->meeting) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время встречи гостей'); });
                    $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->meeting); });
                }

                if ($event->main) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время основного проекта'); });
                    $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->main); });
                }

                if ($event->hot_snacks) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время горячей закуски'); });
                    $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->hot_snacks); });
                }

                if ($event->sorbet) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время сорбет'); });
                    $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->sorbet); });
                }

                if ($event->hot) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время горячего'); });
                    $sheet->cell('I' . $time_index++, function ($cell) use ($event) { $cell->setValue($event->hot); });
                }

                if ($event->dessert) {
                    $sheet->cell('H' . $time_index, function ($cell) { $cell->setValue('Время десерта'); });
                    $sheet->cell('I' . $time_index, function ($cell) use ($event) { $cell->setValue($event->dessert); });
                }

                $sheet->row(1, ['Название', 'Количество', 'Вес порции', 'Общий вес']);
                $row_index = 2;

                foreach ($sections as $section) {
                    if (@$section->category->name != '') {
                        $sheet->cell('A' . $row_index++, function ($cell) use ($section) {
                            $cell->setValue(@$section->category->name);
                            $cell->setFontWeight('bold');
                        });
                    }
                    foreach ($section->rows as $row) {
                        $sheet->row($row_index++, [
                            $row->product->name,
                            $row->amount . ' шт.',
                            $row->product->weight . ' гр.',
                            $row->total_weight . ' гр.'
                        ]);
                    }
                    $row_index++;
                }
            });
        })->download('xls');
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