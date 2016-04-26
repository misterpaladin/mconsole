<?php

namespace Milax\Mconsole\Traits;

use \Illuminate\Database\Eloquent\Relations\HasMany;

trait HasUploads
{
    /**
     * Dynamic hasMany relationship on Upload model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function uploads()
    {
        $instance = new \Milax\Mconsole\Models\Upload;
        return new HasMany($instance->newQuery()->where('related_class', __CLASS__), $this, $instance->getTable().'.'.'related_id', 'id');
    }
}
