<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Repository\PlaceRepository;

/**
 * Class PlaceController
 * @package App\Http\Controllers
 */
class PlaceController extends Controller
{
    private $places;

    /**
     * Create a new controller instance.
     *
     * @param PlaceRepository $places
     */
    public function __construct(PlaceRepository $places)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->places = $places;
    }

    /**
     * Show all places
     *
     * @return string
     */
    public function index()
    {
        $places = $this->places->all();

        return view('places.index')->with('places', $places);
    }

    /**
     * Create new place
     *
     * @return string
     */
    public function create()
    {
        $place = new Place();

        return view('places.create')->with('place', $place);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PlaceRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlaceRequest $request)
    {
        $this->places->create($request->except(['_token']));

        return redirect()->route('places.index');
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
     * Update place
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $place = $this->places->find($id);

        return view('places.update')->with('place', $place);
    }

    /**
     * Save user
     *
     * @param PlaceRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PlaceRequest $request, $id)
    {
        $this->places->update($request->except(['_token']), $id);

        return redirect()->route('places.index');
    }

    /**
     * Remove place
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->places->delete($id);

        return redirect()->route('places.index');
    }
}