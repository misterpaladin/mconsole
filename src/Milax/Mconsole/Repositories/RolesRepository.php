<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\RolesRepository as Repository;

class RolesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\MconsoleRole::class;
    
    public function index()
    {
        return $this->query()->notRoot();
    }
}
