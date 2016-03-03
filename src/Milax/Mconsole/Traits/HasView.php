<?php

namespace Milax\Mconsole\Traits;

use View;

trait HasView
{
    protected function setTitle($value)
    {
        view()->composer('mconsole::app', function ($view) use (&$value) {
            $view->with('pageTitle', $value  . ' | Mconsole');
        });
    }
    
    protected function setCaption($value)
    {
        View::share('pageCaption', $value);
    }
    
    protected function setSubcaption($value)
    {
        View::share('pageSubcaption', $value);
    }
}
