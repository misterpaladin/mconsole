<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Models\Variable;
use String;
use Blade;
use View;

class MconsoleBladeExtensions extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('trans', function ($expression) {
            return '<?php
                $exp = ' . $expression . ';
                foreach ($exp as $key => $value) {
                    echo "<input type=\"hidden\" disabled=\"disabled\" name=\"trans-$key\" value=\"$value\" />";
                }
            ?>';
        });
        
        Blade::directive('datetime', function ($expression) {
            return "<?php echo \Carbon\Carbon::now()->format({$expression}); ?>";
        });
        
        Blade::directive('variable', function ($expression) {
            $string = new String($expression);
            $expression = $string->removeQuote()->removeParenthesis()->getString();
            $variable = Variable::getCached()->where('key', $expression)->first();
            $value = ($variable) ? $variable->value : null;
            
            return "<?php echo \"{$value}\"; ?>";
        });
    }
}
