<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Exceptions\RepositoryException;
use Milax\Mconsole\Repositories\RepositoriesPackage;

class Repositories implements GenericAPI
{
    protected $stash = [];
    
    /**
     * Give a clone of repository instance
     * 
     * @param  string $property [Repository name]
     * @return mixed
     */
    public function __get($property)
    {
        if (isset($this->stash[$property])) {
            return clone $this->stash[$property];
        }
    }
    
    /**
     * Register a repository
     * 
     * @param  string $name          [Repository name]
     * @param  Repository $instance  [Repository instance]
     * @param  string $package       [Package name]
     * @return Repositories
     */
    public function register($name, $instance, $package = null)
    {
        if (isset($this->stash[$name])) {
            throw new RepositoryException(sprintf('Repository name %s is already in use', $name));
        }
        
        if (!is_null($package)) {
            if (!isset($this->stash[$package])) {
                $this->stash[$package] = new RepositoriesPackage;
            }
            $this->stash[$package]->$name = $instance;
        } else {
            $this->stash[$name] = $instance;
        }
        
        return $this;
    }
}
