<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Milax\Mconsole\Contracts\Repositories\VariablesRepository;

class Variables extends RepositoryAPI
{
    public function __construct(VariablesRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Get variable instance by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function getByKey($key)
    {
        return $this->repository->getByKey($key);
    }
    
    /**
     * Get variable value by its key
     * 
     * @param  string $key
     * @return string
     */
    public function getValueByKey($key)
    {
        return $this->getByKey($key)->value;
    }
}
