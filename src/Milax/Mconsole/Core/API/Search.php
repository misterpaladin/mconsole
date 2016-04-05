<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Contracts\API\ServiceAPI;

class Search implements ServiceAPI
{
    protected $stack = [];
    
    public function register($callback)
    {
        $this->stack[] = $callback;
    }
    
    public function handle($text)
    {
        $results = collect();
        foreach ($this->stack as $callback) {
            if ($result = $callback($text)) {
                $results->push($result);
            }
        }
        return $results;
    }
}
