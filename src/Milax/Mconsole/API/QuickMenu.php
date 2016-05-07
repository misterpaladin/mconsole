<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;

class QuickMenu implements GenericAPI
{
    protected $stack = [];
    
    /**
     * Register quick menu item
     * 
     * @param  array $menu
     * @return void
     */
    public function register($menu)
    {
        $this->stack[] = $menu;
    }
    
    /**
     * Get all quick menu items
     * 
     * @return Illumiate\Support\Collection
     */
    public function get()
    {
        $results = collect($this->stack)->transform(function ($item) {
            $item['text'] = trans($item['text']);
            return $item;
        });
        return $results;
    }
}
