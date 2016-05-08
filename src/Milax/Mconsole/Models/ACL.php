<?php

namespace Milax\Mconsole\Models;

class ACL
{
    public $route;
    public $method;
    public $uri;
    public $description;
    public $key;
    
    public $group;
    public $action;
    
    /**
     * Create new instance
     * 
     * @param array $attributes [Default properties]
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                if ($attribute == 'description') {
                    $this->$attribute = trans($value);
                } else {
                    $this->$attribute = $value;
                }
            }
        }
        
        $this->makeGroups();
    }
    
    /**
     * Make groups
     * 
     * @return void
     */
    public function makeGroups()
    {
        if (strlen($this->description) > 0) {
            $groups = explode(':', $this->description);
            $this->group = trim($groups[0]);
            $this->action = trim($groups[1]);
        }
    }
}
