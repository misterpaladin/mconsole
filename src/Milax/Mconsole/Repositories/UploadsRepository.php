<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\UploadsRepository as Repository;

class UploadsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Upload::class;

    public function index()
    {
        return $this->query()->orderBy('id', 'DESC');
    }
}
