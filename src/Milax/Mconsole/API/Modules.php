<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Artisan;
use File;
use Storage;
use Schema;
use DB;

class Modules extends RepositoryAPI
{
    public $modules;
    
    public $provider;
    public $model;
    
    /**
     * Create new loader instance
     */
    public function __construct($model, $provider = null)
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
        $psr4 = require sprintf('%s/../../../../../../../vendor/composer/autoload_psr4.php', __DIR__);
        
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
                        $modules[$key]->register = array_merge_recursive($modules[$key]->register, $module->register);
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
     * Extend module
     * 
     * @param  MconsoleModule $module [Module object]
     * @return int
     */
    public function extend($module)
    {
        return Artisan::call('make:module', [
            'class' => $module->name,
        ]);
    }
    
    /**
     * Install module package migrations, assets
     * 
     * @param  MconsoleModule $module [Module object]
     * @param  bool $update [Disable database queries]
     * @param  bool $dump [Call composer dump-autoload]
     * @return Modules
     */
    public function install($module, $update = false, $dump = true)
    {
        $model = $this->model;
        
        // Install dependencies
        if (isset($module->depends) && count($module->depends) > 0) {
            foreach ($module->depends as $dependency) {
                if (app('API')->modules->get('all')->where('identifier', $dependency)->count() == 0) {
                    return ['status' => 'failed', 'dependency' => $dependency];
                }
            }
            foreach ($module->depends as $dependency) {
                $submodule = $this->get('all')->where('identifier', $dependency)->first();
                $this->install($submodule, false, false);
            }
        }
        
        foreach ($module->migrations as $migration) {
            File::copy($migration, database_path(sprintf('migrations/%s.php', pathinfo($migration, PATHINFO_FILENAME))));
        }
        
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        
        if (!$update) {
            $dbMod = $model::where('identifier', $module->identifier)->first();
            
            if ($dbMod) {
                $dbMod->installed = true;
            } else {
                $dbMod = new $model;
                $dbMod->identifier = $identifier;
                $dbMod->installed = true;
            }
        }
        
        // Install public assets
        if (File::exists(sprintf('%s/assets/public', $module->path)) && File::allFiles(sprintf('%s/assets/public', $module->path))) {
            File::copyDirectory(sprintf('%s/assets/public', $module->path), sprintf('%s/%s/', public_path('massets/modules'), $module->identifier));
        }
        
        if ($dump) {
            chdir(base_path());
            exec('composer dump-autoload');
        }
        
        // Call install function if exists
        if (!is_null($install = $module->install)) {
            $install();
        }
        
        if (!$update) {
            $dbMod->save();
        }
        
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
        
        // Call install function if exists
        if (!is_null($uninstall = $module->uninstall)) {
            $uninstall();
        }
        
        if (count($module->migrations) > 0) {
            foreach ($module->migrations as $migration) {
                DB::table('migrations')->where('migration', pathinfo($migration, PATHINFO_FILENAME))->orderBy('migration', 'asc')->update([
                    'batch' => $batch,
                ]);
            }
            
            Artisan::call('migrate:rollback', [
                '--force' => true,
            ]);
            
            foreach ($module->migrations as $migration) {
                File::delete(database_path(sprintf('migrations/%s.php', pathinfo($migration, PATHINFO_FILENAME))));
            }
        }
        
        $dbMod = $model::where('identifier', $module->identifier)->first();
        $dbMod->installed = false;
        $dbMod->save();
        
        // Uninstall public assets
        if (File::exists(sprintf('%s/%s/', public_path('massets/modules'), $module->identifier))) {
            File::deleteDirectory(sprintf('%s/%s/', public_path('massets/modules'), $module->identifier));
        }
        
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
                    if ($module->init) {
                        $init = $module->init;
                        $init();
                    }
                    $this->provider->routes = array_merge_recursive($this->provider->routes, $module->routes);
                    $this->provider->register = array_merge_recursive($this->provider->register, $module->register);
                    $this->provider->config = array_merge_recursive($this->provider->config, $module->config);
                    $this->provider->views = array_merge_recursive($this->provider->views, $module->views);
                    $this->modules->get('installed')->push($module);
                } else {
                    $this->modules->get('available')->push($module);
                }
                
                // Load translation anyway
                $this->provider->translations = array_merge_recursive($this->provider->translations, $module->translations);
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
        $module->menu = isset($config['menu']) ? $config['menu'] : [];
        $module->depends = isset($config['depends']) ? $config['depends'] : [];
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
        $module->install = null;
        $module->uninstall = null;
        $module->path = $path;
        $module->package = null;
        $module->docs = null;
        $module->public = [
            'css' => [],
            'img' => [],
            'js' => [],
        ];
        
        // Get installation state
        if ($dbModule = $this->dbMods->where('identifier', $module->identifier)->first()) {
            $module->installed = ($dbModule->installed == 1);
        }
        
        // Get init function
        if (isset($config['init'])) {
            $module->init = $config['init'];
        }
        
        // Get install function
        if (isset($config['install'])) {
            $module->install = $config['install'];
        }
        
        // Get uninstall function
        if (isset($config['uninstall'])) {
            $module->uninstall = $config['uninstall'];
        }
        
        // Collect routes
        if (file_exists($routes = sprintf('%s/Http/routes.php', $path))) {
            array_push($module->routes, $routes);
        }
        
        // Collect controllers
        if (File::exists(sprintf('%s/Http/Controllers', $path))) {
            array_push($module->controllers, sprintf('%s/Http/Controllers', $path));
        }
        
        // Collect controllers
        if (File::exists(sprintf('%s/Http/Requests', $path))) {
            array_push($module->requests, sprintf('%s/Http/Requests', $path));
        }
        
        // Collect migrations
        foreach (glob(sprintf('%s/assets/migrations/*.php', $path)) as $migration) {
            array_push($module->migrations, $migration);
        }
        
        // Collect models
        if (File::exists(sprintf('%s/Models', $path))) {
            array_push($module->models, sprintf('%s/Models', $path));
        }
        
        // Collect views
        if (File::exists(sprintf('%s/assets/resources/views', $path))) {
            array_push($module->views, sprintf('%s/assets/resources/views', $path));
        }
        
        // Collect translation files
        if (File::exists(sprintf('%s/assets/resources/lang', $path))) {
            array_push($module->translations, sprintf('%s/assets/resources/lang', $path));
        }
        
        // Public assets
        if (File::exists(sprintf('%s/assets/public', $path)) && File::directories(sprintf('%s/assets/public', $path))) {
            foreach ($module->public as $type => $contents) {
                if (File::exists(sprintf('%s/assets/public/%s', $path, $type))) {
                    if ($allFiles = File::allFiles(sprintf('%s/assets/public/%s', $path, $type))) {
                        foreach ($allFiles as $file) {
                            array_push($module->public[$type], sprintf('/massets/modules/%s/%s/%s', $module->identifier, $type, $file->getRelativePathname()));
                        }
                    }
                }
            }
        }
        
        if (File::exists(sprintf('%s/assets/config', $path))) {
            foreach (glob(sprintf('%s/assets/config/*.php', $path)) as $file) {
                array_push($module->config, $file);
            }
        }
        
        // composer.json
        if (File::exists(sprintf('%s/../../../../composer.json', $path))) {
            $module->package = json_decode(File::get(sprintf('%s/../../../../composer.json', $path)));
        }
        
        // Docs
        if (File::exists(sprintf('%s/../../../../docs', $path))) {
            $module->docs = sprintf('%s/../../../../docs', $path);
        }
        
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
