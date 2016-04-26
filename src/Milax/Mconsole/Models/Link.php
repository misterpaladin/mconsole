<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;
use Milax\Mconsole\Models\Linkable;

class Link extends Model
{
    use \Cacheable;
    
    protected $fillable = ['url', 'title', 'order', 'enabled'];
    
    /**
     * Count all linked elements
     * 
     * @return int
     */
    public function countLinked()
    {
        return Linkable::where('link_id', $this->id)->count();
    }
    
    /**
     * Get linked query by class name
     *
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function linked($class)
    {
        return $this->morphedByMany($class, 'linkable');
    }
    
    /**
     * Get linked items by class name
     * 
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getLinked($class)
    {
        return $this->morphedByMany($class, 'linkable')->get();
    }
    
    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($link) {
            Linkable::where('link_id', $link->id)->delete();
        });
    }
}
