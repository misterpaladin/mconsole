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
            ['GET', 'uploads', 'mconsole::uploads.acl.index', 'uploads'],
            ['GET', 'uploads/create', 'mconsole::uploads.acl.create'],
            ['POST', 'uploads', 'mconsole::uploads.acl.store'],
            ['GET', 'uploads/{uploads}/edit', 'mconsole::uploads.acl.edit'],
            ['PUT', 'uploads/{uploads}', 'mconsole::uploads.acl.update'],
            ['GET', 'uploads/{uploads}', 'mconsole::uploads.acl.show'],
            ['DELETE', 'uploads/{uploads}', 'mconsole::uploads.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'menu', 'mconsole::menu.acl.index', 'menus'],
            ['GET', 'menu/create', 'mconsole::menu.acl.create'],
            ['POST', 'menu', 'mconsole::menu.acl.store'],
            ['GET', 'menu/{menu}/edit', 'mconsole::menu.acl.edit'],
            ['PUT', 'menu/{menu}', 'mconsole::menu.acl.update'],
            ['GET', 'menu/{menu}', 'mconsole::menu.acl.show'],
            ['DELETE', 'menu/{menu}', 'mconsole::menu.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'presets', 'mconsole::presets.acl.index', 'presets'],
            ['GET', 'presets/create', 'mconsole::presets.acl.create'],
            ['POST', 'presets', 'mconsole::presets.acl.store'],
            ['GET', 'presets/{presets}/edit', 'mconsole::presets.acl.edit'],
            ['PUT', 'presets/{presets}', 'mconsole::presets.acl.update'],
            ['GET', 'presets/{presets}', 'mconsole::presets.acl.show'],
            ['DELETE', 'presets/{presets}', 'mconsole::presets.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'roles', 'mconsole::roles.acl.index', 'roles'],
            ['GET', 'roles/create', 'mconsole::roles.acl.create'],
            ['POST', 'roles', 'mconsole::roles.acl.store'],
            ['GET', 'roles/{roles}/edit', 'mconsole::roles.acl.edit'],
            ['PUT', 'roles/{roles}', 'mconsole::roles.acl.update'],
            ['GET', 'roles/{roles}', 'mconsole::roles.acl.show'],
            ['DELETE', 'roles/{roles}', 'mconsole::roles.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'users', 'mconsole::users.acl.index', 'users_list'],
            ['GET', 'users/create', 'mconsole::users.acl.create'],
            ['POST', 'users', 'mconsole::users.acl.store'],
            ['GET', 'users/{users}/edit', 'mconsole::users.acl.edit'],
            ['PUT', 'users/{users}', 'mconsole::users.acl.update'],
            ['GET', 'users/{users}', 'mconsole::users.acl.show'],
            ['DELETE', 'users/{users}', 'mconsole::users.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'tags', 'mconsole::tags.acl.index', 'tags'],
            ['GET', 'tags/create', 'mconsole::tags.acl.create'],
            ['POST', 'tags', 'mconsole::tags.acl.store'],
            ['GET', 'tags/{tags}/edit', 'mconsole::tags.acl.edit'],
            ['PUT', 'tags/{tags}', 'mconsole::tags.acl.update'],
            ['GET', 'tags/{tags}', 'mconsole::tags.acl.show'],
            ['DELETE', 'tags/{tags}', 'mconsole::tags.acl.destroy'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'modules', 'mconsole::modules.acl.index', 'modules'],
            ['GET', 'modules/{id}/extend', 'mconsole::modules.acl.extend'],
            ['GET', 'modules/{id}/install', 'mconsole::modules.acl.install'],
            ['GET', 'modules/{id}/uninstall', 'mconsole::modules.acl.uninstall'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'settings', 'mconsole::settings.acl.index', 'settings'],
            ['POST', 'settings', 'mconsole::settings.acl.store'],
            ['GET', 'settings/clearcache', 'mconsole::settings.acl.clearcache'],
            ['GET', 'settings/reloadtrans', 'mconsole::settings.acl.reloadtrans'],
        ]);
        
        app('API')->acl->register([
            ['GET', 'variables', 'mconsole::variables.acl.index', 'variables'],
            ['POST', 'variables', 'mconsole::variables.acl.store'],
        ]);
    }
}
