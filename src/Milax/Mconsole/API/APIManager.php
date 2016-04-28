<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Exceptions\APINamespaceExistsException;

/**
 * Class for serving mconsole API services
 */
class APIManager
{
    /**
     * Register an API class
     * 
     * @param  string $namespace [API namespace]
     * @param  mixed $instance  [API class instance]
     * @return void
     */
    public function register($namespace, $instance)
    {
        if (property_exists($this, $namespace)) {
            throw new APINamespaceExistsException(sprintf('The namespace "%s" is already registered in API, unable to register', $namespace));
        }
        
        $this->$namespace = $instance;
    }
}
