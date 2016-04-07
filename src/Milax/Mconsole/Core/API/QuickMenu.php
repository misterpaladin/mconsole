<?php

namespace Milax\Mconsole\Core\API;

class QuickMenu
{
    protected $stack = [];
    
    /**
     * Register callback function
     * 
     * @param  Closure $callback
     * @return void
     */
    public function register($callback)
    {
        $this->stack[] = $callback;
    }
    
    /**
     * Get all quick menu items
     * 
     * @return Illumiate\Support\Collection
     */
    public function get()
    {
        $results = collect();
        foreach ($this->stack as $callback) {
            if ($result = $callback()) {
                $results->push($result);
            }
        }
        
        return $results;
    }
}
