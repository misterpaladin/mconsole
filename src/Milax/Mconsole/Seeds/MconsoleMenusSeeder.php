<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\Language;

class MconsoleMenusSeeder
{
    /**
     * Default options with values to create
     * 
     * @var array
     * @access protected
     */
    protected static $menus = [
        [
            'key' => 'main_menu',
            'name' => 'Main menu',
            'tree' => [
                [
                    'text' => 'Home',
                    'link' => 'http://localhost',
                ],
            ],
            'system' => true,
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        collect(self::$menus)->each(function ($menu) {
            if (DB::table('languages')->where('key', $menu['key'])->count() == 0) {
                DB::table('languages')->insert([
                    'key' => $menu['key'],
                    'name' => $menu['name'],
                    'tree' => $menu['tree'],
                    'system' => $menu['system'],
                ]);
            }
        });
        return 'Installed ' . __CLASS__ . '.';
    }
}
