<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Client;
use App\Repository\ServiceRepository;
use Illuminate\Http\Request;

/**
 * Class ServiceController
 * @package App\Http\Controllers
 */
class ServiceController extends Controller
{
    private $services;

    /**
     * Create a new controller instance.
     *
     * @param ServiceRepository $services
     */
    public function __construct(ServiceRepository $services)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->services = $services;
    }

    /**
     * Show all services
     *
     * @return string
     */
    public function index()
    {
        $services = $this->services->all();

        return view('services.index')->with('services', $services);
    }

    /**
     * Create new service
     *
     * @return string
     */
    public function create()
    {
        $service = new Client();

        return view('services.create')->with('service', $service);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ServiceRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $this->services->create($request->except(['_token']));

        return redirect()->route('services.index');
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
     * Update service
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $service = $this->services->find($id);

        return view('services.update')->with('service', $service);
    }

    /**
     * Save user
     *
     * @param ServiceRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, $id)
    {
        $this->services->update($request->except(['_token']), $id);

        return redirect()->route('services.index');
    }

    /**
     * Remove service
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->services->delete($id);

        return redirect()->route('services.index');
    }
}