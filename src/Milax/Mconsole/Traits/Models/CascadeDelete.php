<?php

namespace Milax\Mconsole\Traits\Models;

trait CascadeDelete
{
    /**
     * Register CascadeDelete callback functions
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $methods = get_class_methods(__CLASS__);
        $methods = array_walk($methods, function ($method) {
            if (\Illuminate\Support\Str::startsWith($method, 'cascadeDelete')) {
                self::deleting(function ($object) use ($method) {
                    $object->$method();
                });
            }
        });
    }
}
