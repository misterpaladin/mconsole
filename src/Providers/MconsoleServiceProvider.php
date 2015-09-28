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
		
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'mconsole');
		
		$this->publishes([
			__DIR__ . '/../config/mconsole.php' => base_path('config/mconsole.php'),
		], 'config');
		
		$this->publishes([
			__DIR__ . '/../migrations/2015_09_28_140312_modify_users_table_add_admin_column.php' => base_path('database/migrations/2015_09_28_140312_modify_users_table_add_admin_column.php'),
			__DIR__ . '/../migrations/2015_09_28_141943_create_pages_table.php' => base_path('database/migrations/2015_09_28_141943_create_pages_table.php'),
		], 'migrations');
		
		$this->publishes([
			__DIR__ . '/../User.php' => base_path('app/User.php'),
			__DIR__ . '/../Page.php' => base_path('app/Page.php'),
		], 'models');
		
		$this->publishes([
			__DIR__ . '/../../public' => base_path('public/massets'),
		], 'assets');
	}
}