<?php

namespace Milax\Mconsole\Traits;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasTags
{
    /**
     * Dynamic hasMany relationship on Tag model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tags()
    {
        return $this->morphToMany('Milax\Mconsole\Models\Tag', 'taggable');
    }
}
