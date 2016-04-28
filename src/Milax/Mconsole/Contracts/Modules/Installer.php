<?php

namespace Milax\Mconsole\Contracts\Modules;

interface Installer
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
