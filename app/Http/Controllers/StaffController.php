<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

/**
 * Class StaffController
 * @package App\Http\Controllers
 */
class StaffController extends Controller
{
    private $users;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->users = $users;
    }

    /**
     * Show all users
     *
     * @return string
     */
    public function index()
    {
        $users = $this->users->all();

        return view('staff.index')->with('users', $users);
    }

    /**
     * Create new user
     *
     * @return string
     */
    public function create()
    {
        $user = new User(['job' => 'manager', 'active' => 1, 'work_hours' => 0]);

        return view('staff.create')->with('user', $user);
    }

    /**
     * Update user
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $user = $this->users->find($id);

        return view('staff.update')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if ($request->file('photography')) {
            $request['photo'] = $request->file('photography')->store('public/users');
        }

        $this->users->create($request->except(['_token', 'photography']));

        return redirect()->route('staff.index');
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
     * Save user
     *
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        if ($request->file('photography')) {
            $this->users->find($id)->photoDelete();
            $request['photo'] = $request->file('photography')->store('public/users');
        }

        $this->users->update($request->except(['_token', 'photography']), $id);

        return redirect()->route('staff.index');
    }

    /**
     * Remove user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->users->delete($id);

        return redirect()->route('staff.index');
    }

    /**
     * Save status users
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveActive(Request $request)
    {
        foreach ((array)$request->input('active') as $user_id => $active) {
            $this->users->update(['active' => (int)$active], $user_id);
        }

        return redirect()->route('staff.index');
    }
}