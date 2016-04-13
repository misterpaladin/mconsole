<?php

namespace Milax\Mconsole\Traits;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Milax\Mconsole\Models\TagsToAny;

trait HasTags
{
    /**
     * Dynamic hasMany relationship on Image model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        $instance = new \Milax\Mconsole\Models\Tag;
        return new HasManyThrough($instance->newQuery()->where('related_class', __CLASS__), $this, new TagsToAny, 'related_id', 'id', $this->getKeyName());
    }
}
