<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\DataManager;
use DB;

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
        $result = $model::where('key', $key)->update([
            'value' => $value,
        ]);
        $model::dropCache();
        return $result;
    }
    
    /**
     * Create or update options
     *
     * @param array $options [Options array]
     * @param bool  $force [Overwrite options values]
     * @return void
     */
    public function install($options, $force = false)
    {
        $model = $this->model;
        
        $toInsert = [];
        
        if ($force) {
            $this->uninstall($options);
        }
        
        foreach ($options as $key => $option) {
            $count = DB::table('mconsole_options')->where('key', $option['key'])->count();
            if ($force || $count == 0) {
                foreach ($option as $col => $val) {
                    if (is_array($val)) {
                        $option[$col] = json_encode($val);
                    }
                }
                $option['created_at'] = date('Y-m-d H:i:s');
                $option['updated_at'] = date('Y-m-d H:i:s');
                array_push($toInsert, $option);
            }

            if ($count > 0) {
                $option['rules'] = !empty($option['rules']) ? json_encode($option['rules']) : null;
                $option['options'] = !empty($option['options']) ? json_encode($option['options']) : null;
                DB::table('mconsole_options')->where('key', $option['key'])->update([
                    'group' => $option['group'],
                    'label' => $option['label'],
                    'rules' => $option['rules'],
                    'options' => $option['options'],
                ]);
            }
        }
        
        $model::insert($toInsert);
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
        $model::whereIn('key', collect($options)->pluck('key'))->delete();
        $model::dropCache();
    }
}
