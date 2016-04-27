<?php

namespace Milax\Mconsole\Traits\Models;

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
    
    /**
     * Cascade Delete Tags
     * 
     * @return void
     */
    protected function cascadeDeleteTags()
    {
        app('API')->tags->detach($this);
    }
}
