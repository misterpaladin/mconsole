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
     * @param boolean $noFail [Allow query fails]
     * @return mixed
     */
    public function getByKey($key, $noFail = false)
    {
        return $this->repository->getByKey($key, $noFail);
    }
    
    /**
     * Get variable value by its key
     * 
     * @param  string $key
     * @param boolean $noFail [Allow query fails]
     * @return mixed
     */
    public function getValueByKey($key, $noFail = false)
    {
        $variable = $this->getByKey($key, $noFail);

        if ($variable) {
            return $variable->value;
        }

        return null;
    }
}
