<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class ACLServiceProvider extends ServiceProvider
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
        app('API')->acl->register([
            ['GET', 'uploads', 'uploads.acl.index', 'uploads'],
            ['GET', 'uploads/create', 'uploads.acl.create'],
            ['POST', 'uploads', 'uploads.acl.store'],
            ['GET', 'uploads/{uploads}/edit', 'uploads.acl.edit'],
            ['PUT', 'uploads/{uploads}', 'uploads.acl.update'],
            ['GET', 'uploads/{uploads}', 'uploads.acl.show'],
            ['DELETE', 'uploads/{uploads}', 'uploads.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'menu', 'menu.acl.index', 'menus'],
            ['GET', 'menu/create', 'menu.acl.create'],
            ['POST', 'menu', 'menu.acl.store'],
            ['GET', 'menu/{menu}/edit', 'menu.acl.edit'],
            ['PUT', 'menu/{menu}', 'menu.acl.update'],
            ['GET', 'menu/{menu}', 'menu.acl.show'],
            ['DELETE', 'menu/{menu}', 'menu.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'presets', 'presets.acl.index', 'presets'],
            ['GET', 'presets/create', 'presets.acl.create'],
            ['POST', 'presets', 'presets.acl.store'],
            ['GET', 'presets/{presets}/edit', 'presets.acl.edit'],
            ['PUT', 'presets/{presets}', 'presets.acl.update'],
            ['GET', 'presets/{presets}', 'presets.acl.show'],
            ['DELETE', 'presets/{presets}', 'presets.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'roles', 'roles.acl.index', 'roles'],
            ['GET', 'roles/create', 'roles.acl.create'],
            ['POST', 'roles', 'roles.acl.store'],
            ['GET', 'roles/{roles}/edit', 'roles.acl.edit'],
            ['PUT', 'roles/{roles}', 'roles.acl.update'],
            ['GET', 'roles/{roles}', 'roles.acl.show'],
            ['DELETE', 'roles/{roles}', 'roles.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'users', 'users.acl.index', 'users_list'],
            ['GET', 'users/create', 'users.acl.create'],
            ['POST', 'users', 'users.acl.store'],
            ['GET', 'users/{users}/edit', 'users.acl.edit'],
            ['PUT', 'users/{users}', 'users.acl.update'],
            ['GET', 'users/{users}', 'users.acl.show'],
            ['DELETE', 'users/{users}', 'users.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'tags', 'tags.acl.index', 'tags'],
            ['GET', 'tags/create', 'tags.acl.create'],
            ['POST', 'tags', 'tags.acl.store'],
            ['GET', 'tags/{tags}/edit', 'tags.acl.edit'],
            ['PUT', 'tags/{tags}', 'tags.acl.update'],
            ['GET', 'tags/{tags}', 'tags.acl.show'],
            ['DELETE', 'tags/{tags}', 'tags.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'modules', 'modules.acl.index', 'modules'],
            ['GET', 'modules/{id}/extend', 'modules.acl.extend'],
            ['GET', 'modules/{id}/install', 'modules.acl.install'],
            ['GET', 'modules/{id}/uninstall', 'modules.acl.uninstall'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'settings', 'settings.acl.index', 'settings'],
            ['POST', 'settings', 'settings.acl.store'],
            ['GET', 'settings/clearcache', 'settings.acl.clearcache'],
            ['GET', 'settings/reloadtrans', 'settings.acl.reloadtrans'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'variables', 'variables.acl.index', 'variables'],
            ['POST', 'variables', 'variables.acl.store'],
        ]);
    }
}
