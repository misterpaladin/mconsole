<?php

namespace Milax\Mconsole\Repositories;

/**
 * Repositories package for modules
 */
class RepositoriesPackage
{
    protected $stash = [];
    
    /**
     * Push Repository to stash
     * 
     * @param string $name     [Repository name]
     * @param mixed  $instance [Repository instance]
     */
    public function __set($name, $instance)
    {
        $this->stash[$name] = $instance;
    }
    
    /**
     * Get Repository from stash
     * 
     * @param  string $name     [Repository name]
     * @return [type]           [description]
     */
    public function __get($name)
    {
        return clone $this->stash[$name];
    }
}
