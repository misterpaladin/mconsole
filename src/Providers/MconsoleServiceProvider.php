<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class MconsoleServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('mconsole', function ($app) {
			return new Mconsole;
		});
	}
	
	public function boot()
	{
		require __DIR__ . '/../Http/routes.php';
		
		$this->loadViewsFrom(__DIR__ . '/../../views', 'mconsole');
		$this->publishes([
			__DIR__ . '/migrations/2015_09_28_140312_modify_users_table_add_admin_column.php' => base_path('database/migrations/2015_09_28_140312_modify_users_table_add_admin_column.php'),
		], 'migrations');
	}
}