<?php

namespace Milax\Mconsole\Contracts\Repositories;

interface VariablesRepository
{
    /**
     * Get variable by key
     * 
     * @param  string $key
     * @return string
     */
    public function getByKey($key);
}
