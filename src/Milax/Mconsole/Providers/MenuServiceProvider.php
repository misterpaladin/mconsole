<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
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
        app('API')->menu->push([
            'name' => 'mconsole::uploads.menu.name',
            'url' => 'uploads',
            'visible' => true,
            'enabled' => true,
        ], 'uploads', 'tools.files');
        
        app('API')->menu->push([
            'name' => 'mconsole::presets.menu.name',
            'url' => 'presets',
            'visible' => true,
            'enabled' => true,
        ], 'presets', 'tools.files');
        
        app('API')->menu->push([
            'name' => 'mconsole::tags.menu.name',
            'url' => 'tags',
            'visible' => true,
            'enabled' => true,
        ], 'tags', 'tools');
        
        app('API')->menu->push([
            'name' => 'mconsole::variables.menu.name',
            'url' => 'variables',
            'visible' => true,
            'enabled' => true,
        ], 'variables', 'tools');
        
        app('API')->menu->push([
            'name' => 'mconsole::menus.menu.name',
            'url' => 'menus',
            'visible' => true,
            'enabled' => true,
        ], 'presets', 'tools');
        
        app('API')->menu->push([
            'name' => 'mconsole::languages.menu.name',
            'url' => 'languages',
            'visible' => true,
            'enabled' => true,
        ], 'languages', 'tools');
        
        app('API')->menu->push([
            'name' => 'mconsole::users.menu.name',
            'url' => 'users',
            'visible' => true,
            'enabled' => true,
        ], 'users_list', 'users');
        
        app('API')->menu->push([
            'name' => 'mconsole::roles.menu.name',
            'url' => 'roles',
            'visible' => true,
            'enabled' => true,
        ], 'roles', 'users');
        
        app('API')->menu->push([
            'name' => 'mconsole::modules.menu.name',
            'url' => 'modules',
            'visible' => true,
            'enabled' => true,
        ], 'modules', 'system');
        
        app('API')->menu->push([
            'name' => 'mconsole::settings.menu.name',
            'url' => 'settings',
            'visible' => true,
            'enabled' => true,
        ], 'settings', 'system');
    }
}
