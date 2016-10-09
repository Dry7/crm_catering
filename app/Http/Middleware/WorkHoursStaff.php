<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class WorkHoursStaff
{
    /**
     * Log out if work hours error
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $user = \Auth::user();

        if (is_object($user) and !@$user->isAdmin() and (@$user->getAttributes()['work_hours'] == 1) and !$this->work_hours()) {
            \Auth::logout();
            session()->flash('message', 'Вам отказано в доступе. Обратитесь к руководству.');
            return redirect('/login?work_hours=1');
        } else {
            return $response;
        }
    }

    /**
     * Check work hours
     *
     * @return bool
     */
    private function work_hours()
    {
        if (Carbon::now()->hour < 10) {
            return false;
        } elseif (Carbon::now()->hour < 18) {
            return false;
        } elseif (Carbon::now()->dayOfWeek == Carbon::SATURDAY) {
            return false;
        } elseif (Carbon::now()->dayOfWeek == Carbon::SUNDAY) {
            return false;
        } else {
            return true;
        }
    }
}
