<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;

class Options extends RepositoryAPI implements DataManager
{
    /**
     * Get option value by its key
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
     * Create or update options
     *
     * @param array $options [Options array]
     * @return void
     */
    public function install($options)
    {
        $model = $this->model;
        foreach ($options as $option) {
            if ($model::where('key', $option['key'])->count() == 0) {
                $model::create($option);
            } else {
                unset($option['value']);
                
                if (isset($option['rules'])) {
                    $option['rules'] = json_encode($option['rules']);
                }
                
                if (isset($option['options'])) {
                    $option['options'] = json_encode($option['options']);
                }
                $model::where('key', $option['key'])->update($option);
            }
        }
    }
    
    /**
     * Remove options from database
     *
     * @param array $options [Options array]
     * @return void
     */
    public function uninstall($options)
    {
        $model = $this->model;
        foreach ($options as $option) {
            $model::where('key', $option['key'])->delete();
        }
    }
}
