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
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\LanguagesRepository', 'Milax\Mconsole\Repositories\LanguagesRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\LinksRepository', 'Milax\Mconsole\Repositories\LinksRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\MenusRepository', 'Milax\Mconsole\Repositories\MenusRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\ModulesRepository', 'Milax\Mconsole\Repositories\ModulesRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\PresetsRepository', 'Milax\Mconsole\Repositories\PresetsRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\RolesRepository', 'Milax\Mconsole\Repositories\RolesRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\TagsRepository', 'Milax\Mconsole\Repositories\TagsRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\UploadsRepository', 'Milax\Mconsole\Repositories\UploadsRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\UsersRepository', 'Milax\Mconsole\Repositories\UsersRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\SettingsRepository', 'Milax\Mconsole\Repositories\SettingsRepository');
        $this->app->bind('Milax\Mconsole\Contracts\Repositories\VariablesRepository', 'Milax\Mconsole\Repositories\VariablesRepository');
    }
}
