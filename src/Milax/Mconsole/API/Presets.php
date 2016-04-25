<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\ModelAPI;
use Milax\Mconsole\Contracts\DataManager;

class Presets extends ModelAPI implements DataManager
{
    /**
     * Get preset value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function get($key)
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
        foreach ($presets as $preset) {
            if ($model::where('key', $preset['key'])->count() == 0) {
                $model::create($preset);
            }
        }
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
        foreach ($presets as $preset) {
            $model::where('key', $preset['key'])->delete();
        }
    }
}
