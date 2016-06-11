<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\MenusRepository as Repository;

class MenusRepository extends EloquentRepository implements MenusRepository
{
    public $model = \Milax\Mconsole\Models\Menu::class;
}
