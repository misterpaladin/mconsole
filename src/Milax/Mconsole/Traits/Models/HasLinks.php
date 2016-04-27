<?php

namespace Milax\Mconsole\Traits\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasLinks
{    
    /**
     * Dynamic hasMany relationship on Link model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function links()
    {
        return $this->morphToMany('Milax\Mconsole\Models\Link', 'linkable');
    }
    
    /**
     * Get all links including 
     * 
     * @return [type] [description]
     */
    public function allLinks()
    {
        return $this->links()->orWhere(function ($query) {
            $query->where('linkable_id', $this->linkable_id);
        });
    }
    
    /**
     * Cascade Delete Links
     * 
     * @return void
     */
    protected function cascadeDeleteLinks()
    {
        app('API')->links->detach($this);
    }
}
