<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Request;

class Tags extends RepositoryAPI implements GenericAPI
{
    /**
     * Sync or detach tags
     * 
     * @param  mixed $instance [Related object instance]
     * @return void
     */
    public function sync($instance)
    {
        if ($tags = Request::input('tags')) {
            $instance->tags()->sync($tags);
        } else {
            $instance->tags()->detach();
        }
    }
    
    /**
     * Detach all tags
     *
     * @param mixed $instance [Taggable object]
     * @return mixed
     */
    public function detach($instance)
    {
        return $instance->tags()->detach();
    }
}
