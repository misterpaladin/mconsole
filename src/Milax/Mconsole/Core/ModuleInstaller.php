<?php

namespace Milax\Mconsole\Core;

use Milax\Mconsole\Models\MconsoleModule;
use Artisan;
use DB;
use File;

class ModuleInstaller
{
    /**
     * Install module package migrations, assets
     * 
     * @param  MconsoleModule $module [Module object]
     * @return ModuleInstaller
     */
    public function install(MconsoleModule $module)
    {
        foreach ($module->migrations as $migration) {
            File::copy($migration, database_path(sprintf('migrations/%s.php', pathinfo($migration, PATHINFO_FILENAME))));
        }
        
        Artisan::call('migrate');
        
        $dbMod = MconsoleModule::where('identifier', $module->identifier)->first();
        
        if ($dbMod) {
            $dbMod->installed = true;
        } else {
            $dbMod = new MconsoleModule();
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
     * @return ModuleInstaller
     */
    public function uninstall(MconsoleModule $module)
    {
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
        
        $dbMod = MconsoleModule::where('identifier', $module->identifier)->first();
        $dbMod->installed = false;
        $dbMod->save();
        
        File::deleteDirectory(storage_path('app/lang'));
        
        return $this;
    }
}
