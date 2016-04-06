<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Contracts\Menu as MenuLoader;

class Menu
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
}
