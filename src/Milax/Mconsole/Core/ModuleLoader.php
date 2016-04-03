<?php

namespace Milax\Mconsole\Core;

define('MODULESEARCH', 'Mconsole');
define('BOOTSTRAPFILE', 'bootstrap.php');

use Milax\Mconsole\Models\MconsoleModule;
use File;

class ModuleLoader
{
    protected $provider;
    
    /**
     * Create new loader instance
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }
    
    /**
     * Scan for new modules
     * 
     * @return 
     */
    public function scan()
    {
        $this->dbMods = MconsoleModule::getCached();
        
        $modules = [];
        $psr4 = require sprintf('%s/../../../../../../../vendor/composer/autoload_psr4.php', __DIR__);
        
        // Base modules
        foreach ($psr4 as $class => $path) {
            if (strpos($class, MODULESEARCH) > -1) {
                $file = sprintf('%s/%s', $path[0], BOOTSTRAPFILE);
                if (File::exists($file)) {
                    $config = include $file;
                    array_push($this->provider->modules, $this->makeModule($config, $path[0], 'base'));
                }
            }
        }
        
        // Custom modules
        foreach (glob(app_path('Mconsole/*/bootstrap.php')) as $file) {
            $config = include $file;
            if (is_array($config)) {
                $matched = false;
                
                foreach ($this->provider->modules as $key => $baseModule) {
                    if ($baseModule->identifier == $config['identifier']) {
                        $module = $this->makeModule($config, pathinfo($file, PATHINFO_DIRNAME), 'custom');
                        $this->provider->modules[$key]->original = clone($baseModule);
                        $this->provider->modules[$key]->extend = $module;
                        
                        // Merge custom module with original
                        $this->provider->modules[$key]->controllers = array_merge($this->provider->modules[$key]->controllers, $module->controllers);
                        $this->provider->modules[$key]->models = array_merge($this->provider->modules[$key]->models, $module->models);
                        $this->provider->modules[$key]->routes = array_merge($this->provider->modules[$key]->routes, $module->routes);
                        $this->provider->modules[$key]->views = array_merge($this->provider->modules[$key]->views, $module->views);
                        $this->provider->modules[$key]->migrations = array_merge($this->provider->modules[$key]->migrations, $module->migrations);
                        $this->provider->modules[$key]->type = 'extended';
                        
                        $matched = true;
                        break;
                    }
                }
                
                // .. or push custom module to modules array
                if (!$matched) {
                    $module = $this->collect($module, pathinfo($file, PATHINFO_DIRNAME), 'custom');
                    array_push($this->provider->modules, $module);
                }
            }
        }
        
        if (count($this->provider->modules) > 0) {
            $this->load($this->provider->modules);
        }
    }
    
    /**
     * Load module config
     * 
     * @param  string $file
     * @return void
     */
    public function load($modules)
    {
        if (count($modules) > 0) {
            foreach ($modules as $module) {
                $this->provider->routes = array_merge_recursive($this->provider->routes, $module->routes);
                $this->provider->register = array_merge_recursive($this->provider->register, $module->register);
                $this->provider->config = array_merge_recursive($this->provider->config, $module->config);
                $this->provider->translations = array_merge_recursive($this->provider->translations, $module->translations);
                $this->provider->views = array_merge_recursive($this->provider->views, $module->views);
            }
            
            // Load custom views before base
            $this->provider->views = array_reverse($this->provider->views);
        }
    }
    
    /**
     * Collect module bootstrap info into MconsoleModule object
     *
     * @param array $config [Bootstrap file]
     * @param string $path [Path to module directory]
     * @return Milax\Mconsole\Models\MconsoleModule
     */
    protected function makeModule($config, $path, $type)
    {
        $module = new MconsoleModule();
        
        $module->name = $config['name'];
        $module->identifier = $config['identifier'];
        $module->description = $config['description'];
        $module->register = $config['register'];
        $module->menu = $config['menu'];
        $module->type = $type;
        $module->routes = [];
        $module->migrations = [];
        $module->views = [];
        $module->config = [];
        $module->translations = [];
        $module->models = [];
        $module->controllers = [];
        $module->requests = [];
        $module->installed = false;
        
        // Get installation state
        if ($dbModule = $this->dbMods->where('identifier', $module->identifier)->first()) {
            $module->installed = ($dbModule->installed === 1);
        }
        
        // Collect routes
        if (file_exists($routes = sprintf('%s/Http/routes.php', $path))) {
            array_push($module->routes, $routes);
        }
        
        // Collect controllers
        foreach (glob(sprintf('%s/Http/Controllers/*.php', $path)) as $controller) {
            array_push($module->controllers, $controller);
        }
        
        // Collect controllers
        foreach (glob(sprintf('%s/Http/Requests/*.php', $path)) as $request) {
            array_push($module->requests, $request);
        }
        
        // Collect migrations
        foreach (glob(sprintf('%s/assets/migrations/*.php', $path)) as $migration) {
            array_push($module->migrations, $migration);
        }
        
        // Collect models
        foreach (glob(sprintf('%s/Models/*.php', $path)) as $model) {
            array_push($module->models, $model);
        }
        
        // Collect views
        array_push($module->views, sprintf('%s/assets/resources/views', $path));
        
        return $module;
    }
}
