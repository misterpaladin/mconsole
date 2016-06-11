<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\TagsRepository as Repository;

class TagsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Tag::class;
}
