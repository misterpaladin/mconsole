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
                if (strlen($m->url) > 0) {
                    $all->push($m);
                } else {
                    $all = $all->merge($m->child);
                }
            });
            
            return $all;
        } else {
            return $menu;
        }
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
