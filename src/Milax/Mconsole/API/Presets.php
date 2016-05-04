<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;
use Carbon\Carbon;

class Presets extends RepositoryAPI implements DataManager
{
    /**
     * Get preset value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function getByKey($key)
    {
        $model = $this->model;
        return $model::getByKey($key);
    }
    
    /**
     * Create or update presets
     *
     * @param array $presets [Options array]
     * @return void
     */
    public function install($presets)
    {
        $model = $this->model;
        
        $this->uninstall($presets);
        
        foreach ($presets as $key => $preset) {
            foreach ($preset as $col => $val) {
                if (is_array($val)) {
                    $preset[$col] = json_encode($val);
                    $preset['created_at'] = Carbon::now();
                    $preset['updated_at'] = Carbon::now();
                }
            }
            $presets[$key] = $preset;
        }
        
        $model::insert($presets);
        $model::dropCache();
    }
    
    /**
     * Remove presets from database
     *
     * @param array $presets [Options array]
     * @return void
     */
    public function uninstall($presets)
    {
        $model = $this->model;
        $model::whereIn('key', collect($presets)->lists('key'))->delete();
        $model::dropCache();
    }
}
