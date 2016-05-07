<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;
use Milax\Mconsole\Adapters\PermissionsAdapter;

class MconsoleRole extends Model
{
    protected $fillable = ['name', 'routes', 'widget', 'search'];
    
    /**
     * Get routes as array
     * 
     * @param  string $value
     * @return array
     */
    public function getRoutesAttribute($value)
    {
        return json_decode($value);
    }
    
    /**
     * Set routes attribute
     * 
     * @param string $value
     */
    public function setRoutesAttribute($value)
    {
        $this->attributes['routes'] = json_encode($value);
    }
    
    /**
     * Relationship to User
     * 
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'role_id');
    }
    
    /**
     * Scope to get all roles but not root
     * 
     * @param  Builder $query
     * @return Builder
     */
    public function scopeNotRoot($query)
    {
        return $query->where('key', '!=', 'root');
    }
}
