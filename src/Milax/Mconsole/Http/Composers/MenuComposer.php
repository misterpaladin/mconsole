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
        $allowed = Auth::user()->role->routes;
        $all = $this->menu->load();
        
        $all->each(function ($menu, $key) use (&$all, &$allowed) {
            if (!$menu->visible || !$menu->enabled) {
                unset($all[$key]);
            } else {
                if (isset($menu->child) && count($menu->child) > 0) {
                    foreach ($menu->child as $cKey => $child) {
                        if (Auth::user()->role->key != 'root' && !in_array($child->route, $allowed)) {
                            unset($menu->child[$cKey]);
                        }
                    }
                } else {
                    if (Auth::user()->role->key != 'root' && !in_array($menu->route, $allowed)) {
                        unset($all->child[$key]);
                    }
                }
            }
            if (strlen($menu->url) == 0 && count($menu->child) == 0) {
                unset($all[$key]);
            }
        });
        
        // dd($all);

        // $all->each(function ($menu) use (&$allowed, &$all, &$filtered) {
        //     if ($menu->visible && $menu->enabled) {
        //         if ((Auth::user()->role->key == 'root') || (strlen($menu->url) > 0 && $menu->menu_id == 0 && $allowed->where('id', $menu->id)->count() > 0)) {
        //             $filtered->push($menu);
        //         }
        //         
        //         if ($menu->has('child')) {
        //             foreach ($all->get('child') as $child) {
        //                 if (strlen($child->url) > 0 && in_array($child->route, $allowed)) {
        //                     if ($filtered->where('name', $menu->name)->count() == 0) {
        //                         $filtered->push($menu);
        //                     }
        //                     
        //                     $filtered->push($child);
        //                 }
        //             }
        //         }
        //     }
        // });
        // 
        // dd($filtered);
        // 
        // $menu = $filtered->where('menu_id', 0);
        // 
        // $menu->each(function ($parent) use (&$filtered) {
        //     $parent->child = $filtered->where('menu_id', $parent->id);
        // });

        $view->with('mconsole_menu', $all);
    }
}
