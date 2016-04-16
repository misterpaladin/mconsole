<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleModule;

class ModulesController extends Controller
{
    /**
     * Manage modules
     * @return Response
     */
    public function index()
    {
        $modules = app('API')->modules->get('all');
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
        
        return view('mconsole::modules.list', ['items' => app('API')->modules->get('all')->sortByDesc('name')->sortByDesc('installed')]);
    }
    
    /**
     * Install module
     * @param  string $identifier [Module identifier]
     * @return Response
     */
    public function install($identifier)
    {
        $module = app('API')->modules->get('all')->where('identifier', $identifier)->first();
        app('API')->modules->install($module);
        app('API')->translations->load();
        
        return ['status' => 'ok'];
    }
    
    /**
     * Uninstall module
     * @param  string $identifier [Module identifier]
     * @return Response
     */
    public function uninstall($identifier)
    {
        $module = app('API')->modules->get('all')->where('identifier', $identifier)->first();
        app('API')->modules->uninstall($module);
        app('API')->translations->load();
        
        return ['status' => 'ok'];
    }
    
    /**
     * Extend module
     * 
     * @param  string $identifier [Module identifier]
     * @return Response
     */
    public function extend($identifier)
    {
        $module = app('API')->modules->get('all')->where('identifier', $identifier)->first();
        app('API')->modules->extend($module);
        
        return ['status' => 'ok'];
    }
}
