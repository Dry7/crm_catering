<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('weight', function ($expression) {
            return '<?= number_format((int)' . $expression . ', 0, \'.\', \' \') ; ?> гр.';
        });

        Blade::directive('price', function ($expression) {
            return '<?= number_format(' . $expression . ', 2, \'.\', \' \'); ?> р.';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
