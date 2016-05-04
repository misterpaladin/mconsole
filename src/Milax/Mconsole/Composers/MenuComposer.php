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
        $user = Auth::user();
        $allowed = $user->role->routes;
        $roleKey = $user->role->key;
        $all = app('API')->menu->get();
        
        $all->each(function ($menu, $key) use (&$all, &$allowed, &$acl, &$roleKey) {
            
            if ($menu->acl && $roleKey != 'root') {
                if (!$menu->visible || !$menu->enabled) {
                    unset($all[$key]);
                } else {
                    if (isset($menu->child) && count($menu->child) > 0) {
                        foreach ($menu->child as $cKey => $child) {
                            if ($child->acl) {
                                $current = $acl->where('key', $child->key)->first();
                                if (!in_array($current['route'], $allowed)) {
                                    unset($menu->child[$cKey]);
                                }
                            }
                        }
                    } else {
                        $current = $acl->where('key', $menu->key)->first();
                        if (count($allowed) == 0 || !in_array($current['route'], $allowed)) {
                            $all->forget($key);
                        }
                    }
                }
                
                if (strlen($menu->url) == 0 && count($menu->child) == 0) {
                    $all->forget($key);
                }
            }
        });
        
        $view->with('mconsole_menu', $all);
    }
}
