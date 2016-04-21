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
            $string = $string->removeParenthesis()->getString();
            
            return '<?php
                $args = [' . $string . '];
                $variable = \Milax\Mconsole\Models\Variable::getCached()->where("key", $args[0])->first();
                if ($variable) {
                    $renderer = new \Milax\Mconsole\Blade\BladeRenderer($variable->value, $args[1]);
                    echo $renderer->render();
                }
            ?>';
        });
    }
}
