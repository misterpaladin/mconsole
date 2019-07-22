<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleModule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Cache;
use Milax\Mconsole\Contracts\Repositories\ModulesRepository;

class ModulesController extends Controller
{
    use \UseLayout;
    
    public function __construct(ModulesRepository $repository)
    {
        $this->setCaption(trans('mconsole::modules.menu.name'));
        $this->repository = $repository;
    }
    
    /**
     * Manage modules
     * @return Response
     */
    public function index()
    {
        $modules = app('API')->modules->get('all');
        $cached = $this->repository->get();
        
        $modules->each(function ($module) use (&$cached) {
            $module->installed = false;
            if ($dbModule = $cached->where('identifier', $module->identifier)->first()) {
                $module->installed = $dbModule->installed;
            } else {
                \DB::table('mconsole_modules')->insert([
                    'identifier' => $module->identifier,
                    'installed' => false,
                ]);
            }
        });
        
        return view('mconsole::modules.list', [
            'items' => app('API')->modules->get('all')->sortByDesc('name')->sortByDesc('installed'),
        ]);
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
