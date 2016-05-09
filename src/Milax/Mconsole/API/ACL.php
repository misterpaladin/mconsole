<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Models\ACL as ACLModel;

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
     * @param bool $grouped [Return as grouped collection]
     * @return array
     */
    public function get($grouped = false)
    {
        $collection = collect($this->list)->transform(function ($item) {
            return new ACLModel($item);
        });
        
        if ($grouped) {
            $group = collect([]);
            $collection->each(function ($item) use (&$group) {
                if (!$group->has($item->group)) {
                    $group->put($item->group, collect());
                }
                $group->get($item->group)->push($item);
            });
            
            return $group;
        } else {
            return $collection;
        }
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
        $uri = trim(str_replace('mconsole', null, $uri), '/');
        array_push($this->list, [
            'route' => sprintf('%s:%s', $method, $uri),
            'method' => $method,
            'uri' => $uri,
            'description' => $description,
            'key' => $key,
        ]);
    }
}
