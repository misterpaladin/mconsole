<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Request;

class Links extends RepositoryAPI implements GenericAPI
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
                    app('API')->repositories->links->update($link['id'], $link);
                    array_push($sync, $link['id']);
                } else {
                    array_push($sync, app('API')->repositories->links->create($link)->id);
                }
            }
        }
        
        // dd($sync);

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
        return \Milax\Mconsole\Models\Linkable::groupBy(['id', 'linkable_id', 'linkable_type'])->get();
    }
}
