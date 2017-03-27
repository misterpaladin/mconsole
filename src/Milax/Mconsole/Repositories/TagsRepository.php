<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\TagsRepository as Repository;

class TagsRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Tag::class;

    public function create($data)
    {
        $instance = parent::create($data);
        
        if ($data['category'] == '0') {
            $instance->category = null;
            $instance->save();
        }

        return $instance;
    }
    
    public function update($id, $data)
    {
        $result = parent::update($id, $data);
        $model = $this->model;

        if ($data['category'] == '0') {
            $instance = $model::findOrFail((int) $id);
            $instance->category = null;
            $instance->save();
        }
        
        return $result;
    }
}
