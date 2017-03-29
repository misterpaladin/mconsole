<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;

class QuickMenu implements GenericAPI
{
    protected $stack = [];
    
    /**
     * Register handler function
     * 
     * @param  Closure $handler
     * @return void
     */
    public function register($handler)
    {
        $this->stack[] = $handler;
    }
    
    /**
     * Get all quick menu items
     * 
     * @return Illumiate\Support\Collection
     */
    public function get()
    {
        $results = collect();
        foreach ($this->stack as $handler) {
            if ($result = $handler()) {
                $results->push($result);
            }
        }
        
        return $results;
    }
}
