<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Abstractions\Repositories\EloquentRepository;

class RolesRepository extends EloquentRepository
{
    public function index()
    {
        return $this->query()->notRoot();
    }
}
