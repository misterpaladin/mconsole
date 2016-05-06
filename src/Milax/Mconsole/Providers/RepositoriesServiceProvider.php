<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Register and bind Mconsole repositories
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }
    
    public function register()
    {
        $repositories = [
            [
                'when' => '\Milax\Mconsole\Http\Controllers\MenusController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\MenusRepository(\Milax\Mconsole\Models\Menu::class);
                },
                'bind' => 'menus',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\PresetsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\PresetsRepository(\Milax\Mconsole\Models\MconsoleUploadPreset::class);
                },
                'bind' => 'presets',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\RolesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\RolesRepository(\Milax\Mconsole\Models\MconsoleRole::class);
                },
                'bind' => 'roles',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\TagsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\TagsRepository(\Milax\Mconsole\Models\Tag::class);
                },
                'bind' => 'tags',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\UploadsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\UploadsRepository(\Milax\Mconsole\Models\Upload::class);
                },
                'bind' => 'uploads',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\UsersController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\UsersRepository(\App\User::class);
                },
                'bind' => 'users',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\SettingsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\SettingsRepository(\Milax\Mconsole\Models\MconsoleOption::class);
                },
                'bind' => 'settings',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\VariablesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\VariablesRepository(\Milax\Mconsole\Models\Variable::class);
                },
                'bind' => 'variables',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\ModulesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\ModulesRepository(\Milax\Mconsole\Models\MconsoleModule::class);
                },
                'bind' => 'modules',
            ],
        ];
        
        // Repositories contextual binding
        foreach ($repositories as $repository) {
            $this->app->when($repository['when'])->needs($repository['needs'])->give($repository['give']);
            app('API')->repositories->register($repository['bind'], $repository['give']());
        }
        
        // Register additional repositories to API
        app('API')->repositories->register('languages', new \Milax\Mconsole\Repositories\LanguagesRepository(\Milax\Mconsole\Models\Language::class));
    }
}
