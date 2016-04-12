<?php

namespace Milax\Mconsole\Contracts;

interface ModuleInstaller
{
    /**
     * Module install callback function
     * 
     * @return void
     */
    public static function install();
    
    /**
     * Module uninstall callback function
     * 
     * @return void
     */
    public static function uninstall();
}
