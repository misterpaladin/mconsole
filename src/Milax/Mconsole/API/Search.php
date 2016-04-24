<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\ServiceAPI;

class Search implements ServiceAPI
{
    protected $stack = [];
    
    /**
     * Register search engine callback
     * 
     * @param  Closure $callback
     * @param  string $namespace [Search provider namespace]
     * @return void
     */
    public function register($callback, $namespace = null)
    {
        $this->stack[] = [
            'callback' => $callback,
            'namespace' => $namespace,
        ];
    }
    
    /**
     * Handle search
     * 
     * @param  string $text
     * @param  string $namespace [Search provider namespace]
     * @return Illuminate\Support\Collection
     */
    public function handle($text, $namespace = null)
    {
        $results = collect();
        foreach ($this->stack as $callback) {
            if (!is_null($namespace)) {
                if ($callback['namespace'] != $namespace) {
                    continue;
                }
            }
            
            if ($result = $callback['callback']($text)) {
                $results = $results->merge($result);
            }
        }
        
        return $results;
    }
}
