<?php

namespace Milax\Mconsole\Seeds;

use DB;
use Milax\Mconsole\Models\Menu;
use Milax\Mconsole\Contracts\MconsoleSeeder;

class MconsoleMenusSeeder implements MconsoleSeeder
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
                'en' => [
                    [
                        'text' => 'Home',
                        'link' => 'http://localhost',
                    ],
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
            if (Menu::where('key', $menu['key'])->count() == 0) {
                Menu::create([
                    'key' => $menu['key'],
                    'name' => $menu['name'],
                    'tree' => json_encode($menu['tree']),
                    'system' => $menu['system'],
                ]);
            }
        });
        return 'Installed ' . __CLASS__ . '.';
    }
}
