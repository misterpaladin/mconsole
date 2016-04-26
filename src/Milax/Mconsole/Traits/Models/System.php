<?php

namespace Milax\Mconsole\Traits\Models;

trait System
{
    /**
     * Protect system elements
     * 
     * @return mixed
     */
    public function delete()
    {
        if ($this->system) {
            Session::flash('warning', [trans('mconsole::mconsole.errors.system')]);
            return null;
        } else {
            return parent::delete();
        }
    }
}
