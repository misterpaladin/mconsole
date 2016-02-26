<?php

namespace Milax\Mconsole\Http\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Contracts\Menu;
use Auth;

/**
 * Class for composing mconsole menu
 */
class MenuComposer
{
    
    protected $menu;
    
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }
    
    /**
     * Compose mconsole menu tree.
     * 
     * @access public
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $allowed = Auth::user()->role->menus;
        
        $all = $this->menu->load();
        
        $filtered = collect();
        
        $all->each(function ($menu) use (&$allowed, &$all, &$filtered) {
            if ($menu->visible && $menu->enabled) {
                if ((Auth::user()->role->key == 'root') || (strlen($menu->url) > 0 && $menu->menu_id == 0 && $allowed->where('id', $menu->id)->count() > 0)) {
                    $filtered->push($menu);
                }
                
                if ($all->where('menu_id', $menu->id)->count() > 0) {
                    foreach ($all->where('menu_id', $menu->id) as $child) {
                        if (strlen($child->url) > 0 && $allowed->where('id', $child->id)->count() > 0) {
                            if ($filtered->where('id', $menu->id)->count() == 0) {
                                $filtered->push($menu);
                            }
                            
                            $filtered->push($child);
                        }
                    }
                }
            }
        });
        
        $menu = $filtered->where('menu_id', 0);
        $menu->each(function ($parent) use (&$filtered) {
            $parent->child = $filtered->where('menu_id', $parent->id);
        });
        
        $view->with('mconsole_menu', $menu);
    }
}
