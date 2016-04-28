<?php

namespace Milax\Mconsole\Contracts\Modules;

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
