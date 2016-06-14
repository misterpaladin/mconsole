<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Contracts\Repository;

/**
 * Repository abstract class for module models
 */
abstract class EloquentRepository implements Repository
{
    public function query()
    {
        $model = $this->model;
        return $model::query();
    }
    
    public function index()
    {
        return $this->query();
    }
    
    public function get()
    {
        $model = $this->model;
        return $model::get();
    }
    
    public function find($id)
    {
        $model = $this->model;
        return $model::findOrFail($id);
    }
    
    public function insert($data)
    {
        $model = $this->model;
        return $model::insert($data);
    }
    
    public function create($data)
    {
        $instance = $this->fill($data);
        $instance->save();
        
        return $instance;
    }
    
    public function update($id, $data)
    {
        $model = $this->model;
        
        $instance = $model::findOrFail((int) $id);
        $data = $this->fixDates($instance, $data);
        
        return $model::findOrFail((int) $id)->update($data);
    }
    
    public function destroy($id)
    {
        $model = $this->model;
        return $model::destroy($id);
    }
    
    /**
     * Prepare to store created object
     *
     * @param array $data [Post data]
     * @return mixed
     */
    protected function fill($data)
    {
        $model = $this->model;
        $instance = new $model;
        $parent = get_parent_class($instance);
        
        // Fix Eloquent's fillable bug
        if ($parent != 'Illuminate\Database\Eloquent\Model') {
            $parent = new $parent;
            $instance->fillable(array_merge($parent->getFillable(), $instance->getFillable()));
            $instance->dates(array_merge($parent->getDates(), $instance->getDates()));
        }
        
        $data = $this->fixDates($instance, $data);
        
        $instance->fill($data);
        
        return $instance;
    }
    
    /**
     * Fix null dates
     * 
     * @param  mixed $instance  [Object instance]
     * @param  array $data      [Input data]
     * @return array
     */
    protected function fixDates($instance, $data)
    {
        foreach ($instance->getDates() as $date) {
            if (isset($data[$date])) {
                if (strlen($data[$date]) == 0) {
                    $data[$date] = null;
                }
            }
        }
        
        return $data;
    }
}
