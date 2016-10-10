<?php

namespace App\Http\Middleware;

use Closure;

class ActiveStaff
{
    /**
     * Log out if manager inactive and redirect to login
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $user = \Auth::user();

        if (is_object($user) and !@$user->isAdmin() and (@$user->getAttributes()['active'] == 0)) {
            \Auth::logout();
            session()->flash('message', 'Вам отказано в доступе. Обратитесь к руководству.');
            return redirect('/login?active=1');
        } else {
            return $response;
        }
    }
}
