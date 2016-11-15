<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Support\Facades\Auth;

class Logging
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

        $user = Auth::user();

        /**
         * Login user and not admin
         */
        if ((@$user->id > 0) and (!$user->isAdmin())) {
            Log::info($user->id, Log::action($request), $request->route()->parameters());
        }

        return $response;
    }
}
