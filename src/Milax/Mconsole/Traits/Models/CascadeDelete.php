<?php 

namespace Milax\Mconsole\Traits\Models;

trait CascadeDelete
{
    /**
     * Register CascadeDelete callback functions
     */
    public function __construct()
    {
        parent::__construct();
        $methods = get_class_methods(__CLASS__);
        $methods = array_walk($methods, function($method) {
            if (starts_with($method, 'cascadeDelete')) {
                self::deleting(function($object) use ($method) {
                    $object->$method();
                });
            }
        });
    }
}