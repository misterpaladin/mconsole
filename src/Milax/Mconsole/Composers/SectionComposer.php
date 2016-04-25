<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\MconsoleMenu;
use Milax\Mconsole\Contracts\Menu;
use Request;

class SectionComposer
{
    /**
     * Compose pages title and caption
     * 
     * @param  View   $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Request::route()) {
            $route = Request::route()->getName();
            
            $menu = app('API')->menu->get(true)->where('route', $route)->first();
            
            if ($menu) {
                $view->with('pageTitle', trans('mconsole::' . $menu->translation))
                    ->with('pageCaption', trans('mconsole::' . $menu->translation));
            } 
        } else {
            $view->with('pageTitle', trans('mconsole::mconsole.errors.404.title'))
                ->with('pageCaption', trans('mconsole::mconsole.errors.404.title'));
        }
    }
}
