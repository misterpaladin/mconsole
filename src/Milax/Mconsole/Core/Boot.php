<?php

namespace Milax\Mconsole\Core;

use Milax\Mconsole\MconsoleMenu;

use Cache;
use Auth;
use View;
use DB;

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
	public static function boot()
	{
		self::bootMenu();
		self::bootOptions();
	}
	
	/**
	 * Build menu UI tree.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function bootMenu()
	{
		$all = MconsoleMenu::all();
		$menu = $all->where('menu_id', 0);
		$menu->each(function ($parent) use (&$all) {
			$parent->child = $all->where('menu_id', $parent->id);
		});

		View::share('mconsole_menu', $menu);
	}
	
	/**
	 * Build options.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function bootOptions()
	{
		$options = new \ stdClass();
		collect(DB::table('mconsole_options')->get())->each(function ($option) use (&$options) {
			$options->{$option->key} = $option->value;
		});

		View::share('mconsole_options', $options);
	}
	
}