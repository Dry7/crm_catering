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

        Blade::directive('date', function ($expression) {
            return '<?= ' . $expression . '->format(\'d.m.Y\'); ?>';
        });

        Blade::directive('cp1251', function ($expression) {
            return '<?= iconv(\'utf-8\', \'windows-1251\', ' . $expression . '); ?>';
        });

        Blade::directive('time', function ($expression) {
            return '<?= ' . $expression . '->format(\'H:i\'); ?>';
        });

        Blade::directive('price_person', function ($expression) {
            list($row, $persons) = explode(',', str_replace(['(', ')', ' '], '', $expression));

            return '<?= ceil(' . $row . '->product->price*' . $row . '->amount / ' . $persons . '); ?>';
        });

        Blade::directive('weight_person', function ($expression) {
            list($row, $persons) = explode(',', str_replace(['(', ')', ' '], '', $expression));

            return '<?= ceil(' . $row . '->product->weight*' . $row . '->amount / ' . $persons . '); ?>';
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
