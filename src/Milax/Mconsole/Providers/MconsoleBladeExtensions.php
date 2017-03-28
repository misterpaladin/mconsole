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
        
        Blade::directive('filesByTag', function ($expression) {
            $string = str_remove_parenthesis($expression);

            return $string;
        });
        
        Blade::directive('filesById', function ($expression) {
            $string = str_remove_parenthesis($expression);

            return $string;
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

        /**
         * Display file by id
         */
        Blade::directive('fileById', function ($expression) {
            $string = str_remove_parenthesis($expression);
            
            return '<?php
                $parameters = explode(",", "' . $string . '");
                $id = $parameters[0];
                
                if (count($parameters) > 1) {
                    $template = preg_replace("/\'|\s/", null, $parameters[1]);
                } else {
                    $template = "file-container";
                }

                try {
                    $file = app("Milax\Mconsole\Contracts\Repositories\UploadsRepository")->find($id);
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                    return;
                }

                $variable = \Milax\Mconsole\Models\Variable::getCached()->where("key", $template)->first();
                if ($variable) {
                    $renderer = new \Milax\Mconsole\Blade\BladeRenderer($variable->value, $file);
                    echo $renderer->render();
                }
            ?>';
        });

        /**
         * Display set of files by id
         */
        Blade::directive('filesById', function ($expression) {
            $string = str_remove_parenthesis($expression);
            
            return '<?php
                $parameters = [' . $string . '];
                
                $ids = $parameters[0];
                
                if (count($parameters) > 1) {
                    $template = preg_replace("/\'|\s/", null, $parameters[1]);
                } else {
                    $template = "files-container";
                }

                try {
                    $files = app("Milax\Mconsole\Contracts\Repositories\UploadsRepository")->query()->whereIn("id", $ids)->get();
                } catch (\Exception $e) {
                    \Log::error($e->getMessage());
                    return;
                }

                $variable = \Milax\Mconsole\Models\Variable::getCached()->where("key", $template)->first();
                if ($variable) {
                    $renderer = new \Milax\Mconsole\Blade\BladeRenderer($variable->value, [
                        "files" => $files,
                    ]);
                    echo $renderer->render();
                }
            ?>';
        });
    }
}
