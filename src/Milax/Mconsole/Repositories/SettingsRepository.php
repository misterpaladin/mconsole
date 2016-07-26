<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\SettingsRepository as Repository;

class SettingsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\MconsoleOption::class;
    
    public function get($withDisabled = false)
    {
        $model = $this->model;
        
        if ($withDisabled) {
            return $model::get();
        }
        
        return $model::where('enabled', true)->get();
        
    }
    
}
