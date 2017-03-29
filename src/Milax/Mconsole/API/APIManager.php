<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Exceptions\APINamespaceExistsException;
use Milax\Mconsole\Exceptions\APIClassImplementationException;

/**
 * Class for serving mconsole API services
 */
class APIManager
{
    /**
     * List of required contracts
     * 
     * @var array
     */
    protected $contracts = [
        'Milax\Mconsole\Contracts\API\GenericAPI',
        'Milax\Mconsole\Contracts\API\RepositoryAPI',
        'Milax\Mconsole\Contracts\API\ServiceAPI',
    ];

    /**
     * Register an API class
     * 
     * @param  string $namespace [API namespace]
     * @param  mixed $instance  [API class instance]
     * @param  bool $force  [Ignore existing instance]
     * @return $this
     */
    public function register($namespace, $instance, $force = false)
    {
        $implements = array_merge(class_implements($instance), class_parents($instance));
        
        if (count(array_intersect($implements, $this->contracts)) == 0) {
            throw new APIClassImplementationException(sprintf('Class %s should implement one of given API contracts: %s', get_class($instance), implode(', ', $this->contracts)));
        }

        if (str_contains($namespace, '.')) {
            $namespaces = explode('.', $namespace);
            $namespace = array_pull($namespaces, 0);
            $namespaces = implode('.', $namespaces);
            
            if (!property_exists($this, $namespace)) {
                $this->$namespace = [];
            }
            
            if (array_get($this->$namespace, $namespaces) && !$force) {
                throw new APINamespaceExistsException(sprintf('The namespace "%s" is already registered in API, unable to register', $namespace));
            }
            
            array_set($this->$namespace, $namespaces, $instance);
        } else {
            if (property_exists($this, $namespace) && !$force) {
                throw new APINamespaceExistsException(sprintf('The namespace "%s" is already registered in API, unable to register', $namespace));
            }
            $this->$namespace = $instance;
        }

        return $this;
    }

    /**
     * Replace an API class
     * 
     * @param  string $namespace [API namespace]
     * @param  mixed $instance  [API class instance]
     * @return $this
     */
    public function replace($namespace, $instance)
    {
        return $this->replace($namespace, $instance, true);
    }
}
