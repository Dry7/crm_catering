<?php

namespace App\Http\Middleware;

use App\Repository\UserRepository;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Change last visit date
 *
 * @package App\Http\Middleware
 */
class LastVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $staff = app('App\Repository\UserRepository');
            $staff->update(['lastvisit_at' => Carbon::now()], Auth::id());
        }

        return $response;
    }
}
