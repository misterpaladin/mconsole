<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Models\Variable;
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
        Blade::directive('datetime', function ($expression) {
            return "<?php echo \Carbon\Carbon::now()->format({$expression}); ?>";
        });
        
        Blade::directive('variable', function ($expression) {
            $string = str_remove_parenthesis($expression);
            
            return '<?php
                $args = [' . $string . '];
                $variable = \Milax\Mconsole\Models\Variable::getCached()->where("key", $args[0])->first();
                if ($variable) {
                    $arr = empty($args[1]) ? [] : $args[1];
                    $renderer = new \Milax\Mconsole\Blade\BladeRenderer($variable->value, $arr);
                    echo $renderer->render();
                }
            ?>';
        });
    }
}
