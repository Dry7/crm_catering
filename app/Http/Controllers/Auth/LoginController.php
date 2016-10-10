<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return string
     */
    public function showLoginForm()
    {
        $message = '';

        if (request()->has('active')) {
            $message = 'Вам отказано в доступе. Обратитесь к руководству.';
        }

        if (request()->has('work_hours')) {
            $message = 'Вы можете работать с системой только в рабочее время.';
        }

        return view('auth.login')->with('message', $message);
    }


    public function username()
    {
        return 'username';
    }
}
