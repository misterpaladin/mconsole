<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Contracts\API\ModelAPI;

class Options extends ModelAPI
{
    /**
     * Get option value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function getByKey($key)
    {
        $model = $this->model;
        return $model::getByKey($key);
    }
}
