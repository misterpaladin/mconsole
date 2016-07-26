<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;

class Options extends RepositoryAPI implements DataManager
{
    
    public $model = \Milax\Mconsole\Models\MconsoleOption::class;
    
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
     * Store a new option value by key
     * 
     * @param  string $key
     * @param  string $value
     * @return mixed
     */
    public function setByKey($key, $value)
    {
        $model = $this->model;
        return $model::where('key', $key)->update([
            'value' => $value,
        ]);
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
                }
            }
            $option['created_at'] = date('Y-m-d H:i:s');
            $option['updated_at'] = date('Y-m-d H:i:s');
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
