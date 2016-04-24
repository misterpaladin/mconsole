<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\Menu as MenuLoader;
use Milax\Mconsole\Contracts\API\GenericAPI;

class Menu implements GenericAPI
{
    public $menu;
    protected $loader;
    
    /**
     * Create new Menu instance
     * 
     * @param MenuLoader $menu [Menu loader]
     */
    public function __construct(MenuLoader $menu)
    {
        $this->loader = $menu;
    }
    
    /**
     * Get application menu tree
     * 
     * @param  bool $flatten [True to flat array]
     * @return Illuminate\Support\Collection
     */
    public function get($flatten = false)
    {
        if ($this->menu) {
            $menu = $this->menu;
        } else {
            $menu = $this->loader->load();
        }
        
        if ($flatten) {
            $all = collect();
            
            $menu->each(function ($m) use (&$all) {
                $all = $all->merge($m->child);
            });
            
            return $all;
        } else {
            return $menu;
        }
    }
    
    /**
     * Push menu item to given category
     * 
     * @param  string $category [Root category key]
     * @param  string $key      [Menu key]
     * @param  array $menu     [Menu contents]
     * @return void
     */
    public function push($category, $key, $menu)
    {
        $this->loader->push($category, $key, $menu);
    }
}
