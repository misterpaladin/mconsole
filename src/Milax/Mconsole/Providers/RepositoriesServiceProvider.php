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
                'bind' => 'MenusRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\PresetsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\PresetsRepository(\Milax\Mconsole\Models\MconsoleUploadPreset::class);
                },
                'bind' => 'PresetsRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\RolesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\RolesRepository(\Milax\Mconsole\Models\MconsoleRole::class);
                },
                'bind' => 'RolesRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\TagsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\TagsRepository(\Milax\Mconsole\Models\Tag::class);
                },
                'bind' => 'TagsRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\UploadsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\UploadsRepository(\Milax\Mconsole\Models\Upload::class);
                },
                'bind' => 'UploadsRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\UsersController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\UsersRepository(\App\User::class);
                },
                'bind' => 'UsersRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\SettingsController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\SettingsRepository(\Milax\Mconsole\Models\MconsoleOption::class);
                },
                'bind' => 'SettingsRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\VariablesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\VariablesRepository(\Milax\Mconsole\Models\Variable::class);
                },
                'bind' => 'VariablesRepository',
            ],
            [
                'when' => '\Milax\Mconsole\Http\Controllers\ModulesController',
                'needs' => '\Milax\Mconsole\Contracts\Repository',
                'give' => function () {
                    return new \Milax\Mconsole\Repositories\ModulesRepository(\Milax\Mconsole\Models\MconsoleModule::class);
                },
                'bind' => 'ModulesRepository',
            ],
        ];
        
        // Repositories contextual binding
        foreach ($repositories as $repository) {
            $this->app->when($repository['when'])->needs($repository['needs'])->give($repository['give']);
            $this->app->bind($repository['bind'], $repository['give']);
        }
    }
}
