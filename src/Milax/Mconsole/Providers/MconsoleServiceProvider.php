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
				Collective\Html\HtmlServiceProvider::class,
			],
			
			'aliases' => [
				// Third party packages
				'Gravatar' => \Milax\Gravatar::class,
				'Image' => \Intervention\Image\Facades\Image::class,
				'Form' => Collective\Html\FormFacade::class,
				'Html' => Collective\Html\HtmlFacade::class,
				
				// Helpers
				'String' => \Milax\Mconsole\Helpers\String::class,
				
				// Traits
				'Redirectable' => \Milax\Mconsole\Traits\Redirectable::class,
				'Paginatable' => \Milax\Mconsole\Traits\Paginatable::class,
				'Filterable' => \Milax\Mconsole\Traits\Filterable::class
			],
			
			// Interface to Implementation bindings
			'bindings' => [
				'Milax\Mconsole\Contracts\Menu' => \Milax\Mconsole\Core\Menu\DatabaseMenu::class,
			],
			
			// Dependencies for injection
			'dependencies' => [
				'FileMenu' => \Milax\Mconsole\Core\Menu\FileMenu::class,
				'DatabaseMenu' => \Milax\Mconsole\Core\Menu\DatabaseMenu::class,
			],
			
		];
		
		$this->config = [
			'mconsole.php',
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
		
		// Custom configurations
		foreach ($this->config as $config) {
			if (!file_exists(config_path($config))) {
				$this->publishes([
					__DIR__ . '/../../../../src/config/' . $config => config_path($config)
				], 'config');
			}
		}
		
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
		
		foreach ($this->register['bindings'] as $interface => $implementation)
			$this->app->bind($interface, $implementation);
		
		foreach ($this->register['dependencies'] as $dependency => $class)
			$this->app->bind($dependency, function ($app) use (&$class) {
				return new $class();
			});
		
	}

}
