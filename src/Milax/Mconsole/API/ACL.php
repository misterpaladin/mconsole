<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;

class ACL implements GenericAPI
{
    protected $list = [];
    
    /**
     * Register an uri to access control list
     *
     * @param  mixed $method       [Request method or array]
     * @param  string $uri         [Full uri]
     * @param  string $description [Uri description]
     * @param  string $key         [Key for relation to menu items]
     * @return ACL
     */
    public function register($method, $uri = null, $description = null, $key = null)
    {
        if (is_array($method)) {
            foreach ($method as $list) {
                $this->push($list[0], $list[1], isset($list[2]) ? $list[2] : null, isset($list[3]) ? $list[3] : null);
            }
        } else {
            $this->push($method, $uri, $description, $key);
        }
        
        return $this;
    }
    
    /**
     * Get access control list
     * 
     * @return array
     */
    public function get()
    {
        return $this->list;
    }
    
    /**
     * Push an uri to access control list
     *
     * @param  mixed $method       [Request method or array]
     * @param  string $uri         [Full uri]
     * @param  string $description [Uri description]
     * @param  string $key         [Key for relation to menu items]
     * @return ACL
     */
    protected function push($method, $uri, $description, $key)
    {
        $uri = str_contains('mconsole', $uri) ? $uri : sprintf('mconsole/%s', trim($uri, '/'));
        array_push($this->list, [
            'route' => sprintf('%s:%s', $method, $uri),
            'method' => $method,
            'uri' => $uri,
            'description' => $description,
            'key' => $key,
        ]);
    }
}
