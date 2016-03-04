<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    protected $commands = [
        'mconsole:install' => \Milax\Mconsole\Commands\Installer::class,
        'make:module' => \Milax\Mconsole\Commands\ModuleGenerator::class,
    ];
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
        foreach ($this->commands as $command => $class) {
            $this->app->bind($command, function ($app) use (&$class) {
                return new $class();
            });
        }
    }
}
