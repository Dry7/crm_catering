<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ini_set("pcre.backtrack_limit", "23001337");
        ini_set("pcre.recursion_limit", "23001337");
        if (env('APP_ENV') === 'production') {
            URL::forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        ini_set("pcre.backtrack_limit", "23001337");
        ini_set("pcre.recursion_limit", "23001337");
    }
}
