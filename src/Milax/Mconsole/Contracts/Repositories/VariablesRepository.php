<?php

namespace Milax\Mconsole\Contracts\Repositories;

interface VariablesRepository
{
    /**
     * Get variable by key
     * 
     * @param  string $key
     * @param boolean $noFail [Allow query fails]
     * @return Variable
     */
    public function getByKey($key, $noFail = false);
}
