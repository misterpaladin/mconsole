<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\UploadsRepository as Repository;
use Milax\Mconsole\Traits\Repositories\TaggableRepository;

class UploadsRepository extends EloquentRepository implements Repository
{
    use TaggableRepository;

    public $model = \Milax\Mconsole\Models\Upload::class;

    public function index()
    {
        return $this->query()->orderBy('id', 'DESC');
    }

    /**
     * Get uploads by id
     * 
     * @param  integer || array $id [Uploads id]
     * @return collection
     */
    public function getById($id)
    {
        if (gettype($id) != 'array') $id = [$id];
        return $this->query()->whereIn('id', $id)->orderByRaw(sprintf('FIELD(id,%s)', implode(',', $id)))->get();
    }
}
