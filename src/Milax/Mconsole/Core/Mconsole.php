<?php

namespace Milax\Mconsole\Core;

use Cache;
use Auth;
use View;
use DB;
use App;
use File;

/**
 * Core Mconsole class.
 */
class Mconsole
{
    /**
     * Boot mconsole support vars.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function boot()
    {
        self::setAppVersion();
        self::setLang();
        self::loadViewComposers();
    }
    
    /**
     * Set Application version from latest git tag
     *
     * @return void
     */
    public static function setAppVersion()
    {
        $dir = __DIR__ . '/../../../..';
        if (env('APP_ENV') != 'PRODUCTION') {
            chdir($dir);
            $version = exec('git describe');
            File::put(sprintf('%s/version', $dir), $version);
        }
        define('app_version', File::get(sprintf('%s/version', $dir)));
    }
    
    /**
     * Set language depending on user settings.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function setLang()
    {
        if (strlen($lang = Auth::user()->lang) > 0) {
            App::setLocale($lang);
        }
    }
    
    /**
     * Load view composers.
     *
     * @access public
     * @static
     * @return void
     */
    public static function loadViewComposers()
    {
        view()->composer('mconsole::app', 'Milax\Mconsole\Http\Composers\SectionComposer');
        view()->composer('mconsole::partials.menu', 'Milax\Mconsole\Http\Composers\MenuComposer');
        view()->composer('mconsole::app', 'Milax\Mconsole\Http\Composers\OptionsComposer');
        view()->composer('mconsole::pages.form', 'Milax\Mconsole\Http\Composers\LanguagesComposer');
    }
}
