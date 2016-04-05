<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Contracts\API\ModelAPI;
use Artisan;
use File;
use Storage;
use Schema;
use DB;

define('MODULESEARCH', 'Mconsole');
define('BOOTSTRAPFILE', 'bootstrap.php');

class Modules extends ModelAPI
{
    public $modules;
    
    public $provider;
    protected $model;
    
    /**
     * Create new loader instance
     */
    public function __construct($model, $provider)
    {
        $this->model = $model;
        $this->provider = $provider;
    }
    
    /**
     * Get list of modules
     *
     * @param string $key [Get specific array key]
     * @return array
     */
    public function get($key = null)
    {
        if (is_null($key)) {
            return $this->modules;
        } else {
            return $this->modules->get($key);
        }
    }
    
    /**
     * Scan for new modules
     * 
     * @return Modules
     */
    public function scan()
    {
        $this->resetMods();
        
        $model = $this->model;
        
        if (!Schema::hasTable($model::getQuery()->from)) {
            return;
        }
        
        $this->dbMods = $model::getCached();
        
        $modules = [];
        $psr4 = require sprintf('%s/../../../../../../../../vendor/composer/autoload_psr4.php', __DIR__);
        
        // Base modules
        foreach ($psr4 as $class => $path) {
            if (strpos($class, MODULESEARCH) > -1) {
                $file = sprintf('%s/%s', $path[0], BOOTSTRAPFILE);
                if (File::exists($file)) {
                    $config = include $file;
                    array_push($modules, $this->makeModule($config, $path[0], 'base'));
                }
            }
        }
        
        // Custom modules
        foreach (glob(app_path('Mconsole/*/bootstrap.php')) as $file) {
            $config = include $file;
            if (is_array($config)) {
                $matched = false;
                
                foreach ($modules as $key => $baseModule) {
                    if ($baseModule->identifier == $config['identifier']) {
                        $module = $this->makeModule($config, pathinfo($file, PATHINFO_DIRNAME), 'custom');
                        $modules[$key]->original = clone($baseModule);
                        $modules[$key]->extend = $module;
                        
                        // Merge custom module with original
                        $modules[$key]->controllers = array_merge($modules[$key]->controllers, $module->controllers);
                        $modules[$key]->models = array_merge($modules[$key]->models, $module->models);
                        $modules[$key]->routes = array_merge($modules[$key]->routes, $module->routes);
                        $modules[$key]->views = array_merge($modules[$key]->views, $module->views);
                        $modules[$key]->migrations = array_merge($modules[$key]->migrations, $module->migrations);
                        $modules[$key]->translations = array_merge($modules[$key]->translations, $module->translations);
                        $modules[$key]->type = 'extended';
                        
                        $matched = true;
                        break;
                    }
                }
                
                // .. or push custom module to modules array
                if (!$matched) {
                    $module = $this->makeModule($config, pathinfo($file, PATHINFO_DIRNAME), 'custom');
                    array_push($modules, $module);
                }
            }
        }
        
        if (count($modules) > 0) {
            $this->load($modules);
        }
        
        return $this;
    }
    
    /**
     * Install module package migrations, assets
     * 
     * @param  MconsoleModule $module [Module object]
     * @return Modules
     */
    public function install($module)
    {
        $model = $this->model;
        foreach ($module->migrations as $migration) {
            File::copy($migration, database_path(sprintf('migrations/%s.php', pathinfo($migration, PATHINFO_FILENAME))));
        }
        
        Artisan::call('migrate');
        
        $dbMod = $model::where('identifier', $module->identifier)->first();
        
        if ($dbMod) {
            $dbMod->installed = true;
        } else {
            $dbMod = new $model;
            $dbMod->identifier = $identifier;
            $dbMod->installed = true;
        }
        
        $dbMod->save();
        
        File::deleteDirectory(storage_path('app/lang'));
        
        return $this;
    }
    
    /**
     * Uninstall module package
     * @param  MconsoleModule $module [ModuleObject]
     * @return Modules
     */
    public function uninstall($module)
    {
        $model = $this->model;
        $batch = DB::table('migrations')->max('batch') + 1;
        
        if (count($module->migrations) > 0) {
            foreach ($module->migrations as $migration) {
                DB::table('migrations')->where('migration', pathinfo($migration, PATHINFO_FILENAME))->orderBy('migration', 'asc')->update([
                    'batch' => $batch,
                ]);
            }
            
            Artisan::call('migrate:rollback');
            foreach ($module->migrations as $migration) {
                File::delete(database_path(sprintf('migrations/%s.php', pathinfo($migration, PATHINFO_FILENAME))));
            }
        }
        
        $dbMod = $model::where('identifier', $module->identifier)->first();
        $dbMod->installed = false;
        $dbMod->save();
        
        File::deleteDirectory(storage_path('app/lang'));
        
        return $this;
    }
    
    /**
     * Load module config
     * 
     * @param  string $file
     * @return void
     */
    protected function load($modules)
    {
        if (count($modules) > 0) {
            foreach ($modules as $module) {
                $this->modules->get('all')->push($module);
                if ($module->installed) {
                    $this->provider->routes = array_merge_recursive($this->provider->routes, $module->routes);
                    $this->provider->register = array_merge_recursive($this->provider->register, $module->register);
                    $this->provider->config = array_merge_recursive($this->provider->config, $module->config);
                    if ($module->installed) {
                        $this->provider->translations = array_merge_recursive($this->provider->translations, $module->translations);
                    }
                    $this->provider->views = array_merge_recursive($this->provider->views, $module->views);
                    $this->modules->get('installed')->push($module);
                } else {
                    $this->modules->get('available')->push($module);
                }
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
        $model = $this->model;
        $module = new $model;
        
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
        array_push($module->translations, sprintf('%s/assets/resources/lang', $path));
        
        return $module;
    }
    
    /**
     * Reset modules store to default state
     */
    protected function resetMods()
    {
        $this->modules = collect([
            'all' => collect(),
            'installed' => collect(),
            'available' => collect(),
        ]);
    }
}
