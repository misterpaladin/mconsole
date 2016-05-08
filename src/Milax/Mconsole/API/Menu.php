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
            return collect($this->flatten($menu));
        } else {
            return $menu;
        }
    }
    
    /**
     * Flatten menu items
     * 
     * @param  \Illuminate\Support\Collection $menu [Menu collection]
     * @return \Illuminate\Support\Collection
     */
    protected function flatten($menu)
    {
        $all = collect();
        
        foreach ($menu as $key => $m) {
            $all->put($key, $m);
            if (isset($m->menus) && count($m->menus) > 0) {
                $all = $all->merge($m->menus);
            }
        }
        
        return $all;
    }
    
    /**
     * Push menu item to given category
     * 
     * @param  array $menu      [Menu contents]
     * @param  string $key      [Menu key]
     * @param  string $category [Root category key]
     * @return void
     */
    public function push($menu, $key, $category = null)
    {
        if (is_null($category)) {
            $this->loader->pushRoot($key, $menu);
        } else {
            $this->loader->push($category, $key, $menu);
        }
    }
    
    /**
     * Push root menu item
     * 
     * @param  string $key    [Menu key]
     * @param  array $menu    [Menu array]
     * @return void
     */
    public function pushRoot($key, $menu)
    {
        $this->loader->pushRoot($key, $menu);
    }
}
