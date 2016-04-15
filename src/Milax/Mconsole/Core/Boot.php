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
class Boot
{
    /**
     * Boot mconsole support vars.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function run()
    {
        app('API')->info->setAppVersion('0.3.2');
        self::setLang();
        self::loadViewComposers();
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
        view()->composer('mconsole::partials.upload', 'Milax\Mconsole\Http\Composers\FormImagesUploadComposer');
        view()->composer('mconsole::forms.tags', 'Milax\Mconsole\Http\Composers\TagsInputComposer');
    }
}
