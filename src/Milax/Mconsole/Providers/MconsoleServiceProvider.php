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
            \Milax\Mconsole\Providers\MconsoleBladeExtensions::class,
            \Milax\Mconsole\Providers\CommandsServiceProvider::class,
            \Collective\Html\HtmlServiceProvider::class,
            \Milax\Mconsole\Providers\MconsoleValidatorServiceProvider::class,
            \Milax\Mconsole\Providers\ViewComposersServiceProvider::class,
        ],
        
        'aliases' => [
            // Third party packages
            'Gravatar' => \Milax\Gravatar::class,
            'Image' => \Intervention\Image\Facades\Image::class,
            'Form' => \Collective\Html\FormFacade::class,
            'Html' => \Collective\Html\HtmlFacade::class,
            'Debugbar' => \Barryvdh\Debugbar\Facade::class,
            
            // Helpers
            'String' => \Milax\Mconsole\Helpers\String::class,
            
            // Traits
            'Cacheable' => \Milax\Cacheable::class,
            'HasRedirects' => \Milax\Mconsole\Traits\HasRedirects::class,
            'HasUploads' => \Milax\Mconsole\Traits\HasUploads::class,
            'HasTags' => \Milax\Mconsole\Traits\HasTags::class,
            'ListRenderer' => \Milax\Mconsole\Contracts\ListRenderer::class,
        ],
        
        // Interface to Implementation bindings
        'bindings' => [
            'Milax\Mconsole\Contracts\Menu' => \Milax\Mconsole\Core\Menu\FileMenu::class,
            'Milax\Mconsole\Contracts\Localizator' => \Milax\Mconsole\Processors\ContentLocalizator::class,
            'Milax\Mconsole\Contracts\ListRenderer' => \Milax\Mconsole\Renderers\GenericListRenderer::class,
        ],
        
        // Dependencies for injection
        'dependencies' => [
            'FileMenu' => \Milax\Mconsole\Core\Menu\FileMenu::class,
            'DatabaseMenu' => \Milax\Mconsole\Core\Menu\DatabaseMenu::class,
            'ModuleInstaller' => \Milax\Mconsole\Core\ModuleInstaller::class,
            'GetFilterHandler' => \Milax\Mconsole\Handlers\Filters\GetFilterHandler::class,
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
    
    public $require = [
        __DIR__ . '/../Core/defines.php',
        __DIR__ . '/../Core/helpers.php',
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
        // Required files
        foreach ($this->require as $file) {
            require ($file);
        }
        
        // Register API singleton
        $this->app->singleton('API', function ($app) {
            $api = new \stdClass;
            $api->notifications = new \Milax\Mconsole\Core\API\Notifications(\Milax\Mconsole\Models\MconsoleNotification::class);
            $api->search = new \Milax\Mconsole\Core\API\Search;
            $api->modules = new \Milax\Mconsole\Core\API\Modules(\Milax\Mconsole\Models\MconsoleModule::class, $this);
            $api->menu = new \Milax\Mconsole\Core\API\Menu(new \Milax\Mconsole\Core\Menu\FileMenu);
            $api->quotes = new \Milax\Mconsole\Core\API\Quotes;
            $api->options = new \Milax\Mconsole\Core\API\Options(\Milax\Mconsole\Models\MconsoleOption::class);
            $api->presets = new \Milax\Mconsole\Core\API\Presets(\Milax\Mconsole\Models\MconsoleUploadPreset::class);
            $api->translations = new \Milax\Mconsole\Core\API\Translations($this);
            $api->quickmenu = new \Milax\Mconsole\Core\API\QuickMenu;
            $api->uploads = new \Milax\Mconsole\Core\API\Uploads;
            $api->info = new \Milax\Mconsole\Core\API\Info;
            return $api;
        });
        
        // Run one time setup
        app('API')->modules->scan();
        app('API')->info->setAppVersion('0.3.5');
        
        if (env('APP_ENV') == 'local') {
            app('API')->translations->load();
        }
        
        // Register mconsole singleton
        $this->app->singleton('Mconsole', function ($app) {
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
        
        app('API')->search->register(function ($text) {
            return \App\User::select('id', 'name', 'email')->where('email', 'like', sprintf('%%%s%%', $text))->orWhere('name', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($user) {
                return [
                    'icon' => 'user',
                    'title' => $user->name,
                    'description' => $user->email,
                    'link' => sprintf('/mconsole/users/%s/edit', $user->id),
                ];
            });
        }, 'users');
        
        app('API')->search->register(function ($text) {
            return \Milax\Mconsole\Models\Upload::select('id', 'type', 'path', 'filename', 'copies')->where('id', (int) $text)->orWhere('filename', 'like', sprintf('%%%s%%', $text))->orderBy('type')->get()->transform(function ($file) {
                $string = new \String($file->filename);
                return [
                    'icon' => 'file',
                    'title' => $string->getOriginalFileName(),
                    'filepath' => $file->filename,
                    'path' => $file->path,
                    'description' => '',
                    'basepath' => '/storage/uploads',
                    'original' => $file->type == 'image' ? sprintf('/storage/uploads/%s/original/%s', $file->path, $file->filename) : sprintf('/storage/uploads/%s/%s', $file->path, $file->filename),
                    'copies' => $file->copies,
                    'preview' => $file->type == 'image' ? sprintf('/storage/uploads/%s/mconsole/%s', $file->path, $file->filename) : '',
                    'link' => '#',
                ];
            });
        }, 'uploads');
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
}
