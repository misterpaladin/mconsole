<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleModule;
use Milax\Mconsole\Core\ModuleInstaller;

class ModulesController extends Controller
{
    /**
     * Create new instance
     * 
     * @param ModuleInstaller $installer [Installer instance]
     */
    public function __construct(ModuleInstaller $installer)
    {
        $this->installer = $installer;
    }
    
    /**
     * Manage modules
     * @return Response
     */
    public function index()
    {
        $modules = collect(app('Mconsole')->modules['all']);
        $cached = MconsoleModule::all();
        
        $modules->each(function ($module) use (&$cached) {
            $module->installed = false;
            if ($dbModule = $cached->where('identifier', $module->identifier)->first()) {
                $module->installed = $dbModule->installed;
            } else {
                MconsoleModule::create([
                    'identifier' => $module->identifier,
                    'installed' => false,
                ]);
            }
        });
        
        return view('mconsole::modules.list', ['items' => collect(app('Mconsole')->modules['all'])]);
    }
    
    /**
     * Install module
     * @param  string $identifier [Module identifier]
     * @return Response
     */
    public function install($identifier)
    {
        $module = collect(app('Mconsole')->modules['all'])->where('identifier', $identifier)->first();
        $this->installer->install($module);
        
        return ['status' => 'ok'];
    }
    
    /**
     * Uninstall module
     * @param  string $identifier [Module identifier]
     * @return Response
     */
    public function uninstall($identifier)
    {
        $module = collect(app('Mconsole')->modules['all'])->where('identifier', $identifier)->first();
        $this->installer->uninstall($module);
        
        return ['status' => 'ok'];
    }
}
