<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\SettingsRepository as Repository;

class SettingsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\MconsoleOption::class;
}
