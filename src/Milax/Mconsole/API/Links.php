<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Contracts\API\ModelAPI;
use Request;

class Links extends ModelAPI implements GenericAPI
{
    /**
     * Sync or detach links
     * 
     * @param  mixed $instance [Related object instance]
     * @return void
     */
    public function sync($instance)
    {
        $model = $this->model;
        
        $sync = [];
        
        if ($links = Request::input('links')) {
            foreach (json_decode($links, true) as $link) {
                if (isset($link['id']) && strlen($link['id']) > 0) {
                    array_push($sync, $link['id']);
                } else {
                    array_push($sync, $this->store($link)->id);
                }
            }
        }
        
        $instance->links()->sync($sync);
    }
    
    /**
     * Detach all links
     *
     * @param mixed $instance [Linkable object]
     * @return mixed
     */
    public function detach($instance)
    {
        return $instance->links()->detach();
    }
    
    /**
     * Get grouped sets of links
     * 
     * @return void
     */
    public function getGroupedSets()
    {
        return \Milax\Mconsole\Models\Linkable::groupBy(['linkable_id', 'linkable_type'])->get();
    }
}
