<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Milax\Mconsole\Models\TagsToAny;

class Tag extends Model
{
    protected $fillable = ['name'];
    
    /**
     * Get tagged query by class name
     *
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tagged($class)
    {
        $instance = new $class;
        return new BelongsToMany($instance->newQuery()->where('related_class', $class), $this, (new TagsToAny)->getTable(), 'tag_id', 'related_id', null);
    }
    
    /**
     * Get tagged items by class name
     * 
     * @param string $class [Related class name]
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTagged($class)
    {
        return $this->tagged($class)->get();
    }
}
