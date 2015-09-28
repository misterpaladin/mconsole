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

	}
}