<?php

namespace Milax\Mconsole\Contracts\Repositories;

interface VariablesRepository
{
    /**
     * Get variable by key
     * 
     * @param  string $key
     * @return Variable
     */
    public function getByKey($key);
}
