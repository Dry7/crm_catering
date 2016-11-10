<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    private $clients;
    private $staff;

    /**
     * Create a new controller instance.
     *
     * @param ClientRepository $clients
     * @param UserRepository $staff
     */
    public function __construct(ClientRepository $clients, UserRepository $staff)
    {
        $this->middleware('auth');

        $this->clients = $clients;
        $this->staff = $staff;
    }

    /**
     * Show all clients
     *
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request)
    {
        if ($request->input('user_id', 0) > 0) {
            $clients = $this->clients->findWhere(['user_id' => $request->input('user_id')]);
        } else {
            $clients = $this->clients->all();
        }

        return view('clients.index')->with('clients', $clients);
    }

    /**
     * Create new client
     *
     * @return string
     */
    public function create()
    {
        $client = new Client();

        return view('clients.create')
            ->with('client', $client)
            ->with('staff', $this->staff->lists('username', 'id'))
            ->with('is_admin', \Auth::user()->isAdmin());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            $request['user_id'] = \Auth::user()->id;
        }

        $this->clients->create($request->except(['_token']));

        return redirect()->route('clients.index');
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
     * Update client
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $client = $this->clients->find($id);

        return view('clients.update')
            ->with('client', $client)
            ->with('staff', $this->staff->orderBy('surname')->orderBy('name')->orderBy('patronymic')->orderBy('username')->lists('full_name', 'id'))
            ->with('is_admin', \Auth::user()->isAdmin());
    }

    /**
     * Save user
     *
     * @param ClientRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientRequest $request, $id)
    {
        $this->clients->update($request->except(['_token']), $id);

        return redirect()->route('clients.index');
    }

    /**
     * Remove client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->clients->delete($id);

        return redirect()->route('clients.index');
    }
}