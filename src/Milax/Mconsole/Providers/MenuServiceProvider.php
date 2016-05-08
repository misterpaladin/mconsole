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
            'name' => 'Uploads',
            'translation' => 'uploads.menu.list.name',
            'url' => 'uploads',
            'visible' => true,
            'enabled' => true,
        ], 'uploads', 'tools.files');
        
        app('API')->menu->push([
            'name' => 'Presets',
            'translation' => 'presets.menu.list.name',
            'url' => 'presets',
            'visible' => true,
            'enabled' => true,
        ], 'presets', 'tools.files');
        
        app('API')->menu->push([
            'name' => 'All tags',
            'translation' => 'tags.menu.list.name',
            'url' => 'tags',
            'description' => 'tags.menu.list.description',
            'visible' => true,
            'enabled' => true,
        ], 'tags', 'tools');
        
        app('API')->menu->push([
            'name' => 'Variables',
            'translation' => 'variables.menu.name',
            'url' => 'variables',
            'description' => 'variables.menu.description',
            'visible' => true,
            'enabled' => true,
        ], 'variables', 'tools');
        
        app('API')->menu->push([
            'name' => 'Presets',
            'translation' => 'menus.menu.list.name',
            'url' => 'menus',
            'description' => 'menus.menu.list.description',
            'visible' => true,
            'enabled' => true,
        ], 'presets', 'tools');
        
        app('API')->menu->push([
            'name' => 'All users',
            'translation' => 'users.menu.list.name',
            'url' => 'users',
            'description' => 'users.menu.list.description',
            'visible' => true,
            'enabled' => true,
        ], 'users_list', 'users');
        
        app('API')->menu->push([
            'name' => 'All roles',
            'translation' => 'roles.menu.list.name',
            'url' => 'roles',
            'description' => 'roles.menu.list.description',
            'visible' => true,
            'enabled' => true,
        ], 'roles', 'users');
        
        app('API')->menu->push([
            'name' => 'Manage modules',
            'translation' => 'modules.menu.name',
            'url' => 'modules',
            'description' => 'modules.menu.description',
            'visible' => true,
            'enabled' => true,
        ], 'modules', 'system');
        
        app('API')->menu->push([
            'name' => 'Settings',
            'translation' => 'settings.menu.name',
            'url' => 'settings',
            'description' => 'settings.menu.description',
            'visible' => true,
            'enabled' => true,
        ], 'settings', 'system');
    }
}
