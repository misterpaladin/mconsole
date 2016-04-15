<?php

namespace Milax\Mconsole\Traits;

use \Illuminate\Database\Eloquent\Relations\HasMany;

trait HasImages
{
    /**
     * Dynamic hasMany relationship on Image model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        $instance = new \Milax\Mconsole\Models\Image;
        return new HasMany($instance->newQuery()->where('related_class', __CLASS__), $this, $instance->getTable().'.'.'related_id', 'id');
    }
    
    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($object) {
            $object->images->each(function ($image) {
                $image->delete();
            });
        });
    }
}
