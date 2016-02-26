<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    
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
        $this->commands([
            'mconsole:install',
        ]);
        $this->app->bind('mconsole:install', function ($app) {
            return new \Milax\Mconsole\Commands\Installer;
        });
    }
}
