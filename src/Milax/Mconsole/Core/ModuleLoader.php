<?php

namespace Milax\Mconsole\Core;

define('MODULESEARCH', 'Mconsole');
define('BOOTSTRAPFILE', 'bootstrap.php');

use File;

class ModuleLoader
{
    /**
     * Scan for new modules
     * 
     * @return 
     */
    public static function scan()
    {
        $psr4 = require sprintf('%s/../../../../../../../vendor/composer/autoload_psr4.php', __DIR__);
        foreach ($psr4 as $class => $path) {
            if (strpos($class, MODULESEARCH) > -1) {
                $file = sprintf('%s/%s', $path[0], BOOTSTRAPFILE);
                if (File::exists($file)) {
                    return self::load($file);
                }
            }
        }
    }
    
    /**
     * Load module config
     * 
     * @param  string $file
     * @return void
     */
    public static function load($file)
    {
        return include $file;
    }
    
    /**
     * Install module package migrations, assets
     * 
     * @return void
     */
    public static function install($class)
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
    public static function uninstall($class)
    {
        \Artisan::call('migrate:rollback', [
            '--path' => '',
            '--step' => 100,
        ]);
    }
}
