<?php

namespace Milax\Mconsole\Seeds;

use DB;

class MconsoleMenusSeeder
{
	
	/**
	 * Table name for options
	 * 
	 * (default value: 'mconsole_options')
	 * 
	 * @var string
	 * @access protected
	 */
	protected static $table = 'mconsole_menus';
	
	/**
	 * Default options with values to create
	 * 
	 * @var array
	 * @access protected
	 */
	protected static $menus = [
		[
			'name' => 'Pages',
			'key' => 'pages',
			'translation' => 'menu.pages.name',
			'visible' => true,
			'enabled' => true,
			'child' => [
				[
					'name' => 'All pages',
					'key' => 'pages_all',
					'translation' => 'menu.pages.list.name',
					'url' => 'pages',
					'description' => 'menu.pages.list.description',
					'visible' => true,
					'enabled' => true,
				],
				[
					'name' => 'Create page',
					'key' => 'pages_create',
					'translation' => 'menu.pages.create.name',
					'url' => 'pages/create',
					'description' => 'menu.pages.create.description',
					'visible' => true,
					'enabled' => true,
				],
			],
		],
		[
			'name' => 'Users',
			'key' => 'users',
			'translation' => 'menu.users.name',
			'visible' => true,
			'enabled' => true,
			'child' => [
				[
					'name' => 'All users',
					'key' => 'users_all',
					'translation' => 'menu.users.list.name',
					'url' => 'users',
					'description' => 'menu.users.list.description',
					'visible' => true,
					'enabled' => true,
				],
				[
					'name' => 'Create user',
					'key' => 'users_create',
					'translation' => 'menu.users.create.name',
					'url' => 'users/create',
					'description' => 'menu.users.create.description',
					'visible' => true,
					'enabled' => true,
				],
			],
		],
	];
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public static function run()
	{
		$menuArray = self::$menus;
		collect($menuArray)->each(function ($menu) {
			$exist = DB::table(self::$table)->where('key', $menu['key'])->first();
			if (!is_null($exist)) {
				$id = $exist->id;
				self::update($id, $menu);
			} else {
				$id = self::insert($menu);
			}
			if (null !== $menu['child'] && count($menu['child']) > 0) {
				foreach ($menu['child'] as $child) {
					$childExist = DB::table(self::$table)->where('key', $child['key'])->first();
					if (!is_null($childExist)) {
						$child['menu_id'] = $id;
						self::update($childExist->id, $child);
					} else {
						self::insert($child);
					}
				}
			}
		});
		return 'Installed ' . __CLASS__ . '.';
	}
	
	/**
	 * Insert new menu item.
	 * 
	 * @access protected
	 * @static
	 * @param mixed $menu
	 * @return void
	 */
	protected static function insert($menu)
	{
		return DB::table(self::$table)->insertGetId([
			'menu_id' => (isset($menu['menu_id'])) ? $menu['menu_id'] : 0,
			'name' => (isset($menu['name'])) ? $menu['name'] : '',
			'key' => (isset($menu['key'])) ? $menu['key'] : '',
			'url' => (isset($menu['url'])) ? $menu['url'] : '',
			'translation' => (isset($menu['translation'])) ? $menu['translation'] : '',
			'description' => (isset($menu['description'])) ? $menu['description'] : '',
			'visible' => (isset($menu['visible'])) ? $menu['visible'] : true,
			'enabled' => (isset($menu['enabled'])) ? $menu['enabled'] : true,
		]);
	}
	
	/**
	 * Update existing menu item.
	 * 
	 * @access protected
	 * @static
	 * @param mixed $id
	 * @param mixed $menu
	 * @return void
	 */
	protected static function update($id, $menu)
	{
		DB::table(self::$table)->where('id', $id)->update([
			'menu_id' => (isset($menu['menu_id'])) ? $menu['menu_id'] : 0,
			'name' => (isset($menu['name'])) ? $menu['name'] : '',
			'key' => (isset($menu['key'])) ? $menu['key'] : '',
			'url' => (isset($menu['url'])) ? $menu['url'] : '',
			'translation' => (isset($menu['translation'])) ? $menu['translation'] : '',
			'description' => (isset($menu['description'])) ? $menu['description'] : '',
		]);
	}
}
