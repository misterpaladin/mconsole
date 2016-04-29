<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleModule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Cache;
use Milax\Mconsole\Contracts\Repository;

class ModulesController extends Controller
{
    public function __construct(Repository $repository)
    {
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
                $this->repository->create([
                    'identifier' => $module->identifier,
                    'installed' => false,
                ]);
            }
        });
        
        return view('mconsole::modules.list', [
            'items' => app('API')->modules->get('all')->sortByDesc('name')->sortByDesc('installed'),
            'suggested' => $this->getSuggested($modules),
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
    
    /**
     * Get packages list from packagist.org
     * Cache response for 10 minutes
     * 
     * @param Collection $modules [System modules list]
     * @return array
     */
    protected function getSuggested($modules)
    {
        if (!Cache::has('modules.suggested')) {
            $client = new Client();
            $suggested = [];
            $response = $client->request('GET', 'https://packagist.org/search.json?q=mconsole-');
            $results = json_decode($response->getBody()->getContents());
            
            foreach ($results->results as $package) {
                if ($package->name != 'milax/mconsole' && $modules->where('package.name', $package->name)->count() == 0) {
                    array_push($suggested, $package);
                }
            }
            
            Cache::put('modules.suggested', $suggested, \Carbon\Carbon::now()->addMinutes(10));
        }
        
        return Cache::get('modules.suggested');
    }
}
