<?php

namespace Milax\Mconsole\Core;

define('MODULESEARCH', 'Mconsole');
define('BOOTSTRAPFILE', 'bootstrap.php');

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
        $modules = [];
        $psr4 = require sprintf('%s/../../../../../../../vendor/composer/autoload_psr4.php', __DIR__);
        foreach ($psr4 as $class => $path) {
            if (strpos($class, MODULESEARCH) > -1) {
                $file = sprintf('%s/%s', $path[0], BOOTSTRAPFILE);
                if (File::exists($file)) {
                    $modules[] = include $file;
                }
            }
        }
        
        if (count($modules) > 0) {
            $this->load($modules);
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
                $this->provider->routes = array_merge_recursive($this->provider->routes, $module['routes']);
                $this->provider->register = array_merge_recursive($this->provider->register, $module['register']);
                $this->provider->config = array_merge_recursive($this->provider->config, $module['config']);
                $this->provider->translations = array_merge_recursive($this->provider->translations, $module['translations']);
                $this->provider->views = array_merge_recursive($this->provider->views, $module['views']);
                $this->provider->relationships = array_merge_recursive($this->provider->relationships, $module['relationships']);
            }
        }
    }
    
    /**
     * Install module package migrations, assets
     * 
     * @return void
     */
    public function install($class)
    {
        \Artisan::call('migrate', [
            '--path' => '',
        ]);
    }
    
    /**
     * Uninstall module package
     * 
     * @return void
     */
    public function uninstall($class)
    {
        \Artisan::call('migrate:rollback', [
            '--path' => '',
            '--step' => 100,
        ]);
    }
}
