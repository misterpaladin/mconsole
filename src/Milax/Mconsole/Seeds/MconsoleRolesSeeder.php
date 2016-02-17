<?php

namespace Milax\Mconsole\Seeds;

use DB;

class MconsoleRolesSeeder
{
	
	/**
	 * Table name for options
	 * 
	 * (default value: 'mconsole_options')
	 * 
	 * @var string
	 * @access protected
	 */
	protected static $table = 'mconsole_roles';
	
	/**
	 * Default options with values to create
	 * 
	 * @var array
	 * @access protected
	 */
	protected static $roles = [
		[
			'key' => 'root',
			'name' => 'Root',
		],
	];
	
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public static function run()
	{
		collect(self::$roles)->each(function ($role) {
			if (DB::table(self::$table)->where('key', $role['key'])->count() == 0)
				DB::table(self::$table)->insert([
					'key' => $role['key'],
					'name' => $role['name'],
				]);
		});
		return 'Installed ' . __CLASS__ . '.';
	}
}
