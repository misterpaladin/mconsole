<?php

namespace Milax\Mconsole\Contracts\API;

use Milax\Mconsole\Abstractions\Repositories\EloquentRepository;

/**
 * Repository abstract class for APIs that uses Models
 */
abstract class RepositoryAPI extends EloquentRepository
{
    public $model;
}
