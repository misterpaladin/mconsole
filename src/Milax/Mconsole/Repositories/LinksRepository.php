<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\LinksRepository as Repository;

class LinksRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Link::class;
}
