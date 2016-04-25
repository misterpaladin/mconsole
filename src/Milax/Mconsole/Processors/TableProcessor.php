<?php

namespace Milax\Mconsole\Processors;

use Milax\Mconsole\Contracts\Processor;

class TableProcessor implements Processor
{
    /**
     * Process callbacks for ListRenderer
     * 
     * @param  function $callback
     * @param  Collection $items
     * @return Collection
     */
    public function run($callback, $items)
    {
        $collection = collect();
        
        foreach ($items as $item) {
            $item = $callback($item);
            $cItem = collect();
            
            foreach ($item as $key => $val) {
                $cItem->put($key, $val);
            }
            
            $collection->push($cItem);
        }
        
        return $collection;
    }
}
