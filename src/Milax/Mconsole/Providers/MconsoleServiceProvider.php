<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MconsoleServiceProvider extends ServiceProvider
{
	
	protected $register;
	
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
		parent::__construct($app);
		
		$this->register = [
			'middleware' => [
				'mconsole' => \Milax\Mconsole\Http\Middleware\MconsoleMiddleware::class,
			],
			
			'providers' => [
				\Intervention\Image\ImageServiceProvider::class,
				\Milax\Mconsole\Providers\MconsoleBladeExtensions::class,
				\Milax\Mconsole\Providers\CommandsServiceProvider::class,
			],
			
			'aliases' => [
				'Gravatar' => \Milax\Gravatar::class,
				'Image' => \Intervention\Image\Facades\Image::class,
				
				// Helpers
				'String' => \Milax\Mconsole\Helpers\String::class,
			],
			
		];
		
    }
	
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		require __DIR__ . '/../Http/routes.php';
		
		// Resources
		$this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang', 'mconsole');
		$this->loadViewsFrom(__DIR__ . '/../../../resources/views', 'mconsole');
		
		// Assets
		$this->publishes([
			__DIR__ . '/../../../../public' => base_path('public/massets'),
		], 'assets');
		
		// Copy database migrations
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
		foreach ($this->register['middleware'] as $alias => $class)
			$this->app['router']->middleware($alias, $class);
		
		foreach ($this->register['providers'] as $class)
			$this->app->register($class);
		
		foreach ($this->register['aliases'] as $alias => $class)
			AliasLoader::getInstance()->alias($alias, $class);
		
	}

}
