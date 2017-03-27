<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;
use Milax\Mconsole\Models\Taggable;

class Tag extends Model
{
    use \Cacheable;
    
    protected $fillable = ['name', 'color', 'category'];
    
    /**
     * Count all tagged elements
     * 
     * @return int
     */
    public function countTagged()
    {
        return Taggable::where('tag_id', $this->id)->count();
    }
    
    /**
     * Get tagged query by class name
     *
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tagged($class)
    {
        return $this->morphedByMany($class, 'taggable');
    }
    
    /**
     * Get tagged items by class name
     * 
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTagged($class)
    {
        return $this->morphedByMany($class, 'taggable')->get();
    }

    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($tag) {
            Taggable::where('tag_id', $tag->id)->delete();
        });
    }
}
