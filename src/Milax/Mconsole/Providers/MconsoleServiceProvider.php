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
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['router']->middleware('mconsole', 'Milax\Mconsole\Http\Middleware\MconsoleMiddleware');
		$this->app->register('Milax\Mconsole\Blade\BladeMconsoleExtensions');
		$this->registerCommands();
	}
	
	/**
	 * Register mconsole artisan console commands.
	 * 
	 * @access public
	 * @return void
	 */
	public function registerCommands()
	{
		$this->commands([
			'mconsole:install',
		]);
		$this->app->bind('mconsole:install', function ($app) {
			return new \Milax\Mconsole\Commands\Installer;
		});
	}

}
