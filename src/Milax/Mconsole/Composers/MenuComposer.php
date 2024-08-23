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
                    $all->forget($key);
                } else {
                    if (isset($menu->menus) && count($menu->menus) > 0) {
                        foreach ($menu->menus as $cKey => $child) {
                            if ($child->acl) {
                                $current = $acl->where('key', $child->key)->first();
                                if ($current && !in_array($current->route, $allowed)) {
                                    unset($menu->menus[$cKey]);
                                }
                            }
                            if ($child->menus->count() > 0) {
                                foreach ($child->menus as $scKey => $subChild) {
                                    if ($subChild->acl) {
                                        $current = $acl->where('key', $subChild->key)->first();
                                        if ($current && !in_array($current->route, $allowed)) {
                                            unset($child->menus[$scKey]);
                                        }
                                    }
                                }
                                if ($child->menus->count() == 0) {
                                    unset($menu->menus[$cKey]);
                                }
                            }
                        }
                    } else {
                        $current = $acl->where('key', $menu->key)->first();
                        if (count($allowed) == 0 || ($current && !in_array($current->route, $allowed))) {
                            $all->forget($key);
                        }
                    }
                }
            }
            
            if ((!is_null($menu->url) && strlen($menu->url) == 0) && count($menu->menus) == 0) {
                $all->forget($key);
            }
            
        });
        
        if ($user->menus && count($user->menus) > 0) {
            $all = $this->sortMenu($user->menus, $all);
        }
        
        $view->with('mconsole_menu', $all);
    }
    
    /**
     * Sort menu items with children elements
     *
     * @param User $user [User instance]
     * @param \Iluminate\Support\Collection $menus [Menu collection]
     * @return \Iluminate\Support\Collection
     */
    protected function sortMenu($order, $menus)
    {
        $all = collect();
        foreach ($order as $uMenu) {
            $menus->each(function ($menu, $menuKey) use (&$menus, &$uMenu, &$all) {
                if (isset($uMenu['key']) && $menu->key == $uMenu['key']) {
                    if (isset($uMenu['children']) && $menu->menus && $uMenu['children']) {
                        $menu->menus = $this->sortMenu($uMenu['children'], collect($menu->menus));
                    }
                    $all->put($menuKey, $menus->pull($menuKey));
                }
            });
        }
        
        $menus->each(function ($menu) use (&$all) {
            $all->put($menu->key, $menu);
        });
        
        return $all;
    }
}
