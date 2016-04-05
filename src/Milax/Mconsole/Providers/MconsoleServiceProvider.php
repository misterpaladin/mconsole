<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Milax\Mconsole\Core\ModuleLoader;
use Milax\Mconsole\Models\Language;
use File;
use Schema;

class MconsoleServiceProvider extends ServiceProvider
{
    public $register = [
        'middleware' => [
            'mconsole' => \Milax\Mconsole\Http\Middleware\MconsoleMiddleware::class,
        ],
        
        'providers' => [
            \Intervention\Image\ImageServiceProvider::class,
            \Milax\Mconsole\Providers\MconsoleBladeExtensions::class,
            \Milax\Mconsole\Providers\CommandsServiceProvider::class,
            \Collective\Html\HtmlServiceProvider::class,
            \Milax\Mconsole\Providers\MconsoleValidatorServiceProvider::class,
        ],
        
        'aliases' => [
            // Third party packages
            'Gravatar' => \Milax\Gravatar::class,
            'Image' => \Intervention\Image\Facades\Image::class,
            'Form' => \Collective\Html\FormFacade::class,
            'Html' => \Collective\Html\HtmlFacade::class,
            
            // Helpers
            'String' => \Milax\Mconsole\Helpers\String::class,
            
            // Traits
            'Cacheable' => \Milax\Cacheable::class,
            'Redirectable' => \Milax\Mconsole\Traits\Redirectable::class,
            'Paginatable' => \Milax\Mconsole\Traits\Paginatable::class,
            'Filterable' => \Milax\Mconsole\Traits\Filterable::class,
            'HasQueryTraits' => \Milax\Mconsole\Traits\HasQueryTraits::class,
        ],
        
        // Interface to Implementation bindings
        'bindings' => [
            'Milax\Mconsole\Contracts\Menu' => \Milax\Mconsole\Core\Menu\FileMenu::class,
            'Milax\Mconsole\Contracts\Localizator' => \Milax\Mconsole\Processors\ContentLocalizator::class,
        ],
        
        // Dependencies for injection
        'dependencies' => [
            'FileMenu' => \Milax\Mconsole\Core\Menu\FileMenu::class,
            'DatabaseMenu' => \Milax\Mconsole\Core\Menu\DatabaseMenu::class,
            'ModuleInstaller' => \Milax\Mconsole\Core\ModuleInstaller::class,
        ],
        
    ];
    
    public $routes = [
        __DIR__ . '/../Http/routes.php',
    ];
    
    public $config = [
        'mconsole.php',
    ];
    
    public $translations = [
        __DIR__ . '/../../../resources/lang',
    ];
    
    public $views = [
        __DIR__ . '/../../../resources/views',
    ];
    
    public $modules = [
        'all' => [],
        'installed' => [],
        'available' => [],
    ];
    
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
        $this->moduleLoader = new ModuleLoader($this);
    }
    
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->moduleLoader->scan();
        
        if (!File::exists(storage_path('app/lang'))) {
            File::makeDirectory(storage_path('app/lang'));
            $this->initTranslations();
        }
        
        foreach ($this->routes as $route) {
            require $route;
        }
        
        $this->loadTranslationsFrom(storage_path('app/lang'), 'mconsole');
        
        foreach ($this->views as $view) {
            $this->loadViewsFrom($view, 'mconsole');
        }
        
        // Assets
        $this->publishes([
            __DIR__ . '/../../../../public' => base_path('public/massets'),
        ], 'assets');
        
        // Custom configurations
        foreach ($this->config as $config) {
            if (!file_exists(config_path($config))) {
                $this->publishes([
                    __DIR__ . '/../../../../src/config/' . $config => config_path($config),
                ], 'config');
            } else {
                $this->mergeConfigFrom(
                    __DIR__ . '/../../../../src/config/' . $config, 'config'
                );
            }
        }
        
        // Copy database migrations
        $migrations = [];
        $dir = __DIR__ . '/../../../migrations/';
        collect(scandir(__DIR__ . '/../../../migrations'))->each(function ($file) use (&$dir, &$migrations) {
            if (strpos($file, '.php') !== false) {
                $migrations[$dir . $file] = base_path('database/migrations/' . $file);
            }
        });
        $this->publishes($migrations, 'migrations');
        
        // Register singleton
        $this->app->singleton('Mconsole', function ($app) {
            return $this;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->register['middleware'] as $alias => $class) {
            $this->app['router']->middleware($alias, $class);
        }
        
        foreach ($this->register['providers'] as $class) {
            $this->app->register($class);
        }
        
        foreach ($this->register['aliases'] as $alias => $class) {
            AliasLoader::getInstance()->alias($alias, $class);
        }
        
        foreach ($this->register['bindings'] as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
        
        foreach ($this->register['dependencies'] as $dependency => $class) {
            $this->app->bind($dependency, function ($app) use (&$class) {
                return new $class();
            });
        }
    }
    
    /**
     * Init translations
     * 
     * @return void
     */
    protected function initTranslations()
    {
        if (!Schema::hasTable(Language::getQuery()->from)) {
            return;
        }
        
        $languages = Language::all();
        
        // Delete lang directory in local environment
        if (env('APP_ENV') == 'local') {
            File::deleteDirectory(storage_path('app/lang'));
        }
        
        // Collect translation files
        foreach ($this->translations as $translation) {
            foreach (glob($translation . '/*/*.php') as $lg) {
                foreach ($languages as $language) {
                    if (File::exists($translation . '/'. $language->key . '/' . basename($lg))) {
                        // Create if language directory is not exists
                        if (!File::exists(storage_path('app/lang/' . $language->key))) {
                            File::makeDirectory(storage_path('app/lang/' . $language->key), 0775, true, true);
                        }
                        
                        // Copy new or merge existing translation file
                        if (File::exists(storage_path('app/lang/' . $language->key . '/' . basename($lg)))) {
                            $baseLang = include storage_path('app/lang/' . $language->key . '/' . basename($lg));
                            $customLang = include $lg;
                            $baseLang = array_merge($baseLang, $customLang);
                            File::put(storage_path('app/lang/' . $language->key . '/' . basename($lg)), '<?php return ' . var_export($baseLang, true) . ';');
                        } else {
                            File::copy($lg, storage_path('app/lang/' . $language->key . '/' . basename($lg)));
                        }
                    }
                }
            }
        }
    }
}
