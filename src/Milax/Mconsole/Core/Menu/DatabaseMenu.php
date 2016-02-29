<?php

namespace Milax\Mconsole\Core\Menu;

use Milax\Mconsole\Contracts\Menu;

class DatabaseMenu implements Menu
{
    protected $model = '\Milax\Mconsole\Models\MconsoleMenu';
    
    /**
     * Load menu from database or cache
     * 
     * @return Illuminate\Support\Collection
     */
    public function load()
    {
        $properties = get_class_vars(__CLASS__);
        return $properties['model']::getCached();
    }
}
