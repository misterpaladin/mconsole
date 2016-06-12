<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\UsersRepository as Repository;

class UsersRepository extends EloquentRepository implements Repository
{
    public $model = \App\User::class;
}
