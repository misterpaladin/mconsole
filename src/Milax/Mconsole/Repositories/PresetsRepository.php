<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\PresetsRepository as Repository;

class PresetsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\MconsoleUploadPreset::class;
}
