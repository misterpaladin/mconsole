<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\ModulesRepository as Repository;

class ModulesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\MconsoleModule::class;
}
