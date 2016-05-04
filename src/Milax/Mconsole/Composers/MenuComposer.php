<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Contracts\Menu;
use Auth;

/**
 * Class for composing mconsole menu
 */
class MenuComposer
{
    /**
     * Compose mconsole menu tree.
     * 
     * @access public
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $acl = collect(app('API')->acl->get());
        $allowed = Auth::user()->role->routes;
        $all = app('API')->menu->get();
        
        $all->each(function ($menu, $key) use (&$all, &$allowed, &$acl) {
            if (!$menu->visible || !$menu->enabled) {
                unset($all[$key]);
            } else {
                if (isset($menu->child) && count($menu->child) > 0) {
                    foreach ($menu->child as $cKey => $child) {
                        $current = $acl->where('key', $child->key)->first();
                        if (Auth::user()->role->key != 'root' && !in_array($current['route'], $allowed)) {
                            unset($menu->child[$cKey]);
                        }
                    }
                } else {
                    $current = $acl->where('key', $menu->key)->first();
                    if (Auth::user()->role->key != 'root' && !in_array($current['route'], $allowed)) {
                        unset($all->child[$key]);
                    }
                }
            }
            
            if (strlen($menu->url) == 0 && count($menu->child) == 0) {
                unset($all[$key]);
            }
        });
        
        $view->with('mconsole_menu', $all);
    }
}
