<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use \Cacheable;
    
    protected $fillable = ['name'];
    
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
}
