<?php

namespace Milax\Mconsole\Contracts\Repositories;

interface MenusRepository
{
    /**
     * Get menu by key
     * 
     * @param  string $key
     * @param  string $lang [Language key]
     * @return Milax\Mconsole|Models\Menu
     */
    public function findByKey($key, $lang = null);
}
