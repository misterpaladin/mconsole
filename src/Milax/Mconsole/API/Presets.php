<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;

class Presets extends RepositoryAPI implements DataManager
{
    
    public $model = \Milax\Mconsole\Models\MconsoleUploadPreset::class;
    
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
        
        $toInsert = [];
        
        foreach ($presets as $key => $preset) {
            if ($model::where('key', $preset['key'])->count() == 0) {
                foreach ($preset as $col => $val) {
                    if (is_array($val)) {
                        $preset[$col] = json_encode($val);
                    }
                }
                $preset['created_at'] = date('Y-m-d H:i:s');
                $preset['updated_at'] = date('Y-m-d H:i:s');
                array_push($toInsert, $preset);
            }
        }
        
        $model::insert($toInsert);
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
        $model::whereIn('key', collect($presets)->pluck('key'))->delete();
        $model::dropCache();
    }
}
