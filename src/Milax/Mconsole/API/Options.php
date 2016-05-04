<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;
use Carbon\Carbon;

class Options extends RepositoryAPI implements DataManager
{
    /**
     * Get option value by its key
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
     * Create or update options
     *
     * @param array $options [Options array]
     * @return void
     */
    public function install($options)
    {
        $model = $this->model;
        
        $this->uninstall($options);
        
        foreach ($options as $key => $option) {
            foreach ($option as $col => $val) {
                if (is_array($val)) {
                    $option[$col] = json_encode($val);
                    $preset['created_at'] = Carbon::now();
                    $preset['updated_at'] = Carbon::now();
                }
            }
            $options[$key] = $option;
        }
        
        $model::insert($options);
        $model::dropCache();
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
        $model::whereIn('key', collect($options)->lists('key'))->delete();
        $model::dropCache();
    }
}
