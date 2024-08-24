<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class MconsoleServiceProvider extends ServiceProvider
{
    public $register = [
        'middleware' => [
            'mconsole' => \Milax\Mconsole\Http\Middleware\MconsoleMiddleware::class,
        ],
        
        'providers' => [
            \Intervention\Image\ImageServiceProvider::class,
            \MisterPaladin\Cleaner\CleanerServiceProvider::class,
            \MisterPaladin\JSTrans\JSTransServiceProvider::class,
            \Milax\Mconsole\Providers\ACLServiceProvider::class,
            \Milax\Mconsole\Providers\MenuServiceProvider::class,
            \Milax\Mconsole\Providers\SearchServiceProvider::class,
            \Milax\Mconsole\Providers\MconsoleBladeExtensions::class,
            \Milax\Mconsole\Providers\CommandsServiceProvider::class,
            \Milax\Mconsole\Providers\MconsoleValidatorServiceProvider::class,
            \Milax\Mconsole\Providers\ViewComposersServiceProvider::class,
            \Milax\Mconsole\Providers\ScheduleServiceProvider::class,
        ],
        
        'aliases' => [
            // Third party packages
            'Gravatar' => \MisterPaladin\Gravatar::class,
            'Image' => \Intervention\Image\Facades\Image::class,
            'Arr' => \Illuminate\Support\Arr::class,
            'Str' => \Illuminate\Support\Str::class,
            
            // Traits
            'Cacheable' => \MisterPaladin\Cacheable::class,
            'HasRedirects' => \Milax\Mconsole\Traits\Controllers\HasRedirects::class,
            'DoesNotHaveShow' => \Milax\Mconsole\Traits\Controllers\DoesNotHaveShow::class,
            'UseLayout' => \Milax\Mconsole\Traits\Controllers\UseLayout::class,
            'HasUploads' => \Milax\Mconsole\Traits\Models\HasUploads::class,
            'HasLinks' => \Milax\Mconsole\Traits\Models\HasLinks::class,
            'HasTags' => \Milax\Mconsole\Traits\Models\HasTags::class,
            'HasState' => \Milax\Mconsole\Traits\Models\HasState::class,
            'System' => \Milax\Mconsole\Traits\Models\System::class,
            'CascadeDelete' => \Milax\Mconsole\Traits\Models\CascadeDelete::class,
            'TaggableRepository' => \Milax\Mconsole\Traits\Repositories\TaggableRepository::class,
            
            // Enum
            'MconsoleUploadType' => \Milax\Mconsole\Structs\MconsoleUploadType::class,
            'MconsoleFormSelectType' => \Milax\Mconsole\Structs\MconsoleFormSelectType::class,
        ],
        
        // Interface to Implementation bindings
        'bindings' => [
            'Milax\Mconsole\Contracts\Menu' => \Milax\Mconsole\Menu\FileMenu::class,
            'Milax\Mconsole\Contracts\ContentLocalizator' => \Milax\Mconsole\Processors\ContentLocalizator::class,
            'Milax\Mconsole\Contracts\ListRenderer' => \Milax\Mconsole\Renderers\GenericListRenderer::class,
            'Milax\Mconsole\Contracts\FormRenderer' => \Milax\Mconsole\Renderers\GenericFormRenderer::class,
            'Milax\Mconsole\Contracts\PagingHandler' => \Milax\Mconsole\Handlers\GenericPagingHandler::class,
            'Milax\Mconsole\Contracts\FormConstructor' => \Milax\Mconsole\Constructors\GenericFormConstructor::class,
            'Milax\Mconsole\Contracts\ContentCompiler' => \Milax\Mconsole\Compilers\BladeContentCompiler::class,
            'Milax\Mconsole\Contracts\LanguageManager' => \Milax\Mconsole\Language\PrefixLanguageManager::class,
        ],
        
        // Dependencies for injection
        'dependencies' => [
            'FileMenu' => \Milax\Mconsole\Menu\FileMenu::class,
            'DatabaseMenu' => \Milax\Mconsole\Menu\DatabaseMenu::class,
            'GetFilterHandler' => \Milax\Mconsole\Handlers\Filters\GetFilterHandler::class,
            'ParseDown' => \Parsedown::class,
        ],
        
    ];
    
    public $routes = [
        __DIR__ . '/../Http/routes.php',
    ];
    
    public $config = [
        __DIR__ . '/../../../../src/config/mconsole.php',
        __DIR__ . '/../../../../src/config/cleaner.php',
    ];
    
    public $translations = [
        __DIR__ . '/../../../resources/lang',
    ];
    
    public $views = [
        __DIR__ . '/../../../resources/views',
    ];
    
    public $require = [
        __DIR__ . '/../defines.php',
        __DIR__ . '/../helpers.php',
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
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Boot components
        $this->registerRepositories();
        $this->registerAPIs();
        
        // Run one time setup
        app('API')->modules->scan();
        app('API')->info->setAppVersion(MX_VERSION);
        
        if (env('APP_ENV') == 'local') {
            app('API')->translations->load();
        }
        
        // Register mconsole singleton
        $this->app->singleton('mconsole', function ($app) {
            return $this;
        });
        
        // Register service providers
        foreach ($this->register['providers'] as $class) {
            $this->app->register($class);
        }

        foreach ($this->routes as $route) {
            require $route;
        }

        $this->loadTranslationsFrom(storage_path('app/lang'), 'mconsole');
        
        foreach ($this->views as $view) {
            $this->loadViewsFrom($view, 'mconsole');
        }
        
        // Custom configurations
        foreach ($this->config as $config) {
            if (!file_exists(config_path(basename($config)))) {
                $this->publishes([
                    $config => config_path(basename($config)),
                ], 'mconsole');
            } else {
                $this->mergeConfigFrom(
                    $config, pathinfo($config, PATHINFO_FILENAME)
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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register API singleton
        $this->app->singleton('API', function ($app) {
            return new \Milax\Mconsole\API\APIManager;
        });
        
        // Required files
        foreach ($this->require as $file) {
            require $file;
        }
        
        foreach ($this->register['middleware'] as $alias => $class) {
            $this->app['router']->aliasMiddleware($alias, $class);
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
    
    public function registerRepositories()
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
    
    /**
     * Register APIs
     * 
     * @return void
     */
    protected function registerAPIs()
    {
        app('API')->register('notifications', new \Milax\Mconsole\API\Notifications);
        app('API')->register('search', new \Milax\Mconsole\API\Search);
        app('API')->register('modules', new \Milax\Mconsole\API\Modules($this));
        app('API')->register('menu', new \Milax\Mconsole\API\Menu(new \Milax\Mconsole\Menu\FileMenu));
        app('API')->register('quotes', new \Milax\Mconsole\API\Quotes);
        app('API')->register('options', new \Milax\Mconsole\API\Options);
        app('API')->register('presets', new \Milax\Mconsole\API\Presets);
        app('API')->register('translations', new \Milax\Mconsole\API\Translations($this));
        app('API')->register('quickmenu', new \Milax\Mconsole\API\QuickMenu);
        app('API')->register('uploads', new \Milax\Mconsole\API\Uploads);
        app('API')->register('info', new \Milax\Mconsole\API\Info);
        app('API')->register('links', app('Milax\Mconsole\API\Links'));
        app('API')->register('tags', new \Milax\Mconsole\API\Tags);
        app('API')->register('acl', new \Milax\Mconsole\API\ACL);
        app('API')->register('repositories', new \Milax\Mconsole\API\Repositories);
        app('API')->register('forms', app(\Milax\Mconsole\API\Forms::class));
        app('API')->register('variables', $this->app->make('Milax\Mconsole\API\Variables'));
        app('API')->register('sitemap', new \Milax\Mconsole\API\SitemapManager);
        app('API')->sitemap->setHandler(new \Milax\Mconsole\Components\SitemapHandler);
    }
}
