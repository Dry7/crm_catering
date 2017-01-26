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
            return '<?= ' . $expression . ' ? ' . $expression . '->format(\'d.m.Y\') : \'\'; ?>';
        });

        Blade::directive('cp1251', function ($expression) {
            return '<?= iconv(\'utf-8\', \'windows-1251\', @' . $expression . '); ?>';
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
            return '<?php $product = App\Models\Product::find(' . $expression . '); if ($product->photo_has) { echo \'<img src="\' . $product->photo_base64 . \'" style="margin: 0 50px; width: 20%;" />\'; } ?>';
        });

        Blade::directive('image_doc', function ($expression) {
            return '<?php $product = App\Models\Product::find(' . $expression . '); ' . "\n" .
            'if ($product and $product->photo_has) { ' . "\n" .
              '$size = $product->getPhotoSizeAttribute(400); ' . "\n" .
              'echo \'<img src=3D"\' . env(\'APP_URL\') . $product->photo_url . \'" width=3D\' . round($size->width/2) . \' height=3D\' . round($size->height/2) . \' />\';' . "\n" .
            '} ?>';
        });

        Blade::directive('image_base64', function ($expression) {
            return "<?php echo 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('img/$expression'))) ?>";
        });

        Blade::directive('discount', function ($expression) {
            list($price, $discount) = explode(',', str_replace([' '], '', $expression));

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
