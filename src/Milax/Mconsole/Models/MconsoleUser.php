<?php

namespace Milax\Mconsole\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MconsoleUser extends Authenticatable
{
    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lang',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Magic method to load relationships
     * 
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $class_name = class_basename($this);

        $config = implode('.', [$class_name, $method]);
        $relationships = app('Mconsole')->relationships;

        if (array_has($relationships, $config)) {
            $function = array_get($relationships, $config);
            return $function($this);
        }

        return parent::__call($method, $parameters);
    }
    
    /**
     * Get a relationship.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.

        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }
        
        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        try {
            return $this->getRelationshipFromMethod($key);
        } catch (\BadMethodCallException $e) {
            return null;
        }
    }
}
