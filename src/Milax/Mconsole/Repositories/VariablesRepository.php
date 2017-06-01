<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\VariablesRepository as Repository;

class VariablesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Variable::class;
    
    public function getByKey($key, $noFail = false)
    {
        $query = $this->query()->where('key', $key);
        
        if ($noFail) {
            return $query->first();
        } else {
            return $query->firstOrFail();
        }
    }
}
