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
            ['GET', 'uploads', 'mconsole::uploads.acl.index'],
            ['GET', 'uploads/create', 'mconsole::uploads.acl.create'],
            ['POST', 'uploads', 'mconsole::uploads.acl.store'],
            ['GET', 'uploads/{upload}/edit', 'mconsole::uploads.acl.edit'],
            ['PUT', 'uploads/{upload}', 'mconsole::uploads.acl.update'],
            ['GET', 'uploads/{upload}', 'mconsole::uploads.acl.show'],
            ['DELETE', 'uploads/{upload}', 'mconsole::uploads.acl.destroy'],
            ['GET', 'api/uploads/get', 'mconsole::uploads.acl.uploadlist'],
            ['POST', 'api/uploads/upload', 'mconsole::uploads.acl.upload'],
            ['GET', 'api/uploads/delete/{file}', 'mconsole::uploads.acl.uploaddelete'],
        ], 'uploads');
        
        app('API')->acl->register([
            ['GET', 'menus', 'mconsole::menu.acl.index'],
            ['GET', 'menus/create', 'mconsole::menu.acl.create'],
            ['POST', 'menus', 'mconsole::menu.acl.store'],
            ['GET', 'menus/{menu}/edit', 'mconsole::menu.acl.edit'],
            ['PUT', 'menus/{menu}', 'mconsole::menu.acl.update'],
            ['GET', 'menus/{menu}', 'mconsole::menu.acl.show'],
            ['DELETE', 'menus/{menu}', 'mconsole::menu.acl.destroy'],
        ], 'menus');
        
        app('API')->acl->register([
            ['GET', 'presets', 'mconsole::presets.acl.index'],
            ['GET', 'presets/create', 'mconsole::presets.acl.create'],
            ['POST', 'presets', 'mconsole::presets.acl.store'],
            ['GET', 'presets/{preset}/edit', 'mconsole::presets.acl.edit'],
            ['PUT', 'presets/{preset}', 'mconsole::presets.acl.update'],
            ['GET', 'presets/{preset}', 'mconsole::presets.acl.show'],
            ['DELETE', 'presets/{preset}', 'mconsole::presets.acl.destroy'],
        ], 'presets');
        
        app('API')->acl->register([
            ['GET', 'roles', 'mconsole::roles.acl.index'],
            ['GET', 'roles/create', 'mconsole::roles.acl.create'],
            ['POST', 'roles', 'mconsole::roles.acl.store'],
            ['GET', 'roles/{role}/edit', 'mconsole::roles.acl.edit'],
            ['PUT', 'roles/{role}', 'mconsole::roles.acl.update'],
            ['GET', 'roles/{role}', 'mconsole::roles.acl.show'],
            ['DELETE', 'roles/{role}', 'mconsole::roles.acl.destroy'],
        ], 'roles');
        
        app('API')->acl->register([
            ['GET', 'users', 'mconsole::users.acl.index'],
            ['GET', 'users/create', 'mconsole::users.acl.create'],
            ['POST', 'users', 'mconsole::users.acl.store'],
            ['GET', 'users/{user}/edit', 'mconsole::users.acl.edit'],
            ['PUT', 'users/{user}', 'mconsole::users.acl.update'],
            ['GET', 'users/{user}', 'mconsole::users.acl.show'],
            ['DELETE', 'users/{user}', 'mconsole::users.acl.destroy'],
        ], 'users_list');
        
        
        app('API')->acl->register([
            ['GET', 'languages', 'mconsole::languages.acl.index'],
            ['GET', 'languages/create', 'mconsole::languages.acl.create'],
            ['POST', 'languages', 'mconsole::languages.acl.store'],
            ['GET', 'languages/{language}/edit', 'mconsole::languages.acl.edit'],
            ['PUT', 'languages/{language}', 'mconsole::languages.acl.update'],
            ['GET', 'languages/{language}', 'mconsole::languages.acl.show'],
            ['DELETE', 'languages/{language}', 'mconsole::languages.acl.destroy'],
        ], 'languages');
        
        app('API')->acl->register([
            ['GET', 'tags', 'mconsole::tags.acl.index'],
            ['GET', 'tags/create', 'mconsole::tags.acl.create'],
            ['POST', 'tags', 'mconsole::tags.acl.store'],
            ['GET', 'tags/{tag}/edit', 'mconsole::tags.acl.edit'],
            ['PUT', 'tags/{tag}', 'mconsole::tags.acl.update'],
            ['GET', 'tags/{tag}', 'mconsole::tags.acl.show'],
            ['DELETE', 'tags/{tag}', 'mconsole::tags.acl.destroy'],
        ], 'tags');
        
        app('API')->acl->register([
            ['GET', 'modules', 'mconsole::modules.acl.index'],
            ['GET', 'modules/{module}/extend', 'mconsole::modules.acl.extend'],
            ['GET', 'modules/{module}/install', 'mconsole::modules.acl.install'],
            ['GET', 'modules/{module}/uninstall', 'mconsole::modules.acl.uninstall'],
        ], 'modules');
        
        app('API')->acl->register([
            ['GET', 'settings', 'mconsole::settings.acl.index'],
            ['POST', 'settings', 'mconsole::settings.acl.store'],
            ['GET', 'settings/clearcache', 'mconsole::settings.acl.clearcache'],
            ['GET', 'settings/reloadtrans', 'mconsole::settings.acl.reloadtrans'],
        ], 'settings');
        
        app('API')->acl->register([
            ['GET', 'variables', 'mconsole::variables.acl.index'],
            ['POST', 'variables', 'mconsole::variables.acl.store'],
        ], 'variables');
    }
}
