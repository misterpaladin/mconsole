<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class MconsoleServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		require __DIR__ . '/../Http/routes.php';
		
		$this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang', 'mconsole');
		$this->loadViewsFrom(__DIR__ . '/../../../resources/views', 'mconsole');
		
		// Copy or merge mconsole configuration
/*
		if (file_exists(base_path('config/mconsole.php')))
			$this->mergeConfigFrom(
				__DIR__ . '/../../../config/mconsole.php', 'mconsole'
			);
		else
			$this->publishes([
				__DIR__ . '/../../../config/mconsole.php' => base_path('config/mconsole.php'),
			], 'config');
*/
		
		// Assets
		$this->publishes([
			__DIR__ . '/../../../../public' => base_path('public/massets'),
		], 'assets');
		
		// Database migrations
		$migrations = [];
		$dir = __DIR__ . '/../../../migrations/';
		collect(scandir(__DIR__ . '/../../../migrations'))->each(function ($file) use (&$dir, &$migrations) {
			if (strpos($file, '.php') !== false)
				$migrations[$dir . $file] = base_path('database/migrations/' . $file);
		});
		$this->publishes($migrations, 'migrations');
		
		// Database seeds
		$seeds = [];
		$dir = __DIR__ . '/../../../seeds/';
		collect(scandir(__DIR__ . '/../../../seeds'))->each(function ($file) use (&$dir, &$seeds) {
			if (strpos($file, '.php') !== false)
				$seeds[$dir . $file] = base_path('database/seeds/' . $file);
		});
		$this->publishes($seeds, 'seeds');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['router']->middleware('mconsole', 'Milax\Mconsole\Http\Middleware\MconsoleMiddleware');
	}

}
