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

        Blade::directive('image', function ($expression) {
            return '<?php $product = App\Models\Product::find(' . $expression . '); if ($product->photo_has) { echo \'<img src="\' . $product->photo_base64 . \'" />\'; } ?>';
        });

        Blade::directive('image_doc', function ($expression) {
            return '<?php $product = App\Models\Product::find(' . $expression . '); ' .
            'if ($product->photo_has) { ' .
              '$size = $product->getPhotoSizeAttribute(680); ' .
              'echo \'<img src=3D"\' . env(\'APP_URL\') . $product->photo_url . \'" width=3D\' . $size->width . \' height=3D\' . $size->height . \' />\'; ' .
            '} ?>';
        });

        Blade::directive('discount', function ($expression) {
            list($price, $discount) = explode(',', str_replace(['(', ')', ' '], '', $expression));

            return '<?= ceil(' . $price . ' - ' . $price . '/100*' . $discount . '); ?>';
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
