<?php

namespace Milax\Mconsole\Traits;

use View;

trait HasView
{
    protected function setTitle($value)
    {
        View::share('pageTitle', $value . ' | Mconsole');
        return $this;
    }
    
    protected function setCaption($value)
    {
        View::share('pageCaption', $value);
        return $this;
    }
    
    protected function setSubcaption($value)
    {
        View::share('pageSubcaption', $value);
        return $this;
    }
}
