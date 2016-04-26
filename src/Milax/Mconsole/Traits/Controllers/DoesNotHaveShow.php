<?php 

namespace Milax\Mconsole\Traits\Controllers;

trait DoesNotHaveShow
{
    public function show($id) {
        $route = str_replace('show', 'index', \Request::route()->getName());
        return redirect()->route($route);
    }
}