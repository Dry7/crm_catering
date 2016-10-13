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
            return '<?= ' . $expression . '; ?> гр.';
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
