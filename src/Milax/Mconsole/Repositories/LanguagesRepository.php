<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\LanguagesRepository as Repository;

class LanguagesRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Language::class;
}
