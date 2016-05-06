<?php

namespace Milax\Mconsole\Menu;

use Milax\Mconsole\Contracts\Menu;

class FileMenu implements Menu
{
    /**
     * Create new class instance, define menu
     */
    public function __construct()
    {
        $this->menu = [
            'dashboard' => [
                'name' => 'Dashboard',
                'translation' => 'menu.dashboard.name',
                'url' => 'dashboard',
                'description' => 'menu.dashboard.description',
                'visible' => true,
                'enabled' => true,
                'acl' => false,
                'child' => [],
            ],
            'content' => [
                'name' => 'Content',
                'translation' => 'menu.content.name',
                'visible' => true,
                'enabled' => true,
                'child' => [],
            ],
            'tools' => [
                'name' => 'Tools',
                'translation' => 'menu.tools.name',
                'visible' => true,
                'enabled' => true,
                'child' => [
                    'uploads' => [
                        'name' => 'Uploads',
                        'translation' => 'uploads.menu.list.name',
                        'url' => 'uploads',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'presets' => [
                        'name' => 'Presets',
                        'translation' => 'presets.menu.list.name',
                        'url' => 'presets',
                        'description' => 'presets.menu.list.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'tags' => [
                        'name' => 'All tags',
                        'translation' => 'tags.menu.list.name',
                        'url' => 'tags',
                        'description' => 'tags.menu.list.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'variables' => [
                        'name' => 'Variables',
                        'translation' => 'variables.menu.name',
                        'url' => 'variables',
                        'description' => 'variables.menu.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'menus' => [
                        'name' => 'Presets',
                        'translation' => 'menus.menu.list.name',
                        'url' => 'menus',
                        'description' => 'menus.menu.list.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                ],
            ],
            'users' => [
                'name' => 'Users',
                'translation' => 'menu.users.name',
                'visible' => true,
                'enabled' => true,
                'child' => [
                    'users_list' => [
                        'name' => 'All users',
                        'translation' => 'users.menu.list.name',
                        'url' => 'users',
                        'description' => 'users.menu.list.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'roles' => [
                        'name' => 'All roles',
                        'translation' => 'roles.menu.list.name',
                        'url' => 'roles',
                        'description' => 'roles.menu.list.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                ],
            ],
            'system' => [
                'name' => 'System',
                'translation' => 'menu.system.name',
                'visible' => true,
                'enabled' => true,
                'child' => [
                    'modules' => [
                        'name' => 'Manage modules',
                        'translation' => 'modules.menu.name',
                        'url' => 'modules',
                        'description' => 'modules.menu.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'settings' => [
                        'name' => 'Settings',
                        'translation' => 'settings.menu.name',
                        'url' => 'settings',
                        'description' => 'settings.menu.description',
                        'visible' => true,
                        'enabled' => true,
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Load menu from modules bootstrap files
     * 
     * @return Illuminate\Support\Collection
     */
    public function load()
    {
        $fileMenu = collect();
        
        foreach (app('API')->modules->get('installed') as $module) {
            if ($module->menu) {
                foreach ($module->menu as $key => $menu) {
                    $this->appendCategory($key, $menu);
                }
            }
        }
        
        foreach ($this->menu as $key => $menu) {
            $m = $this->convert($menu, $key);
            if (isset($menu['child'])) {
                foreach ($menu['child'] as $cKey => $child) {
                    $m->child[] = $this->convert($child, $cKey);
                }
            }
            $fileMenu->push($m);
        }
        
        return $fileMenu;
    }
    
    /**
     * Convert menu item array to MconsoleMenu object
     * 
     * @param  array $array
     * @return MconsoleMenu
     */
    protected function convert($array, $key = null)
    {
        $properties = get_class_vars(__CLASS__);
        $menu = new $properties['model'];
        
        $menu->menu_id = (isset($array['menu_id'])) ? $array['menu_id'] : 0;
        $menu->name = (isset($array['name'])) ? $array['name'] : '';
        $menu->url = (isset($array['url'])) ? $array['url'] : '';
        $menu->translation = (isset($array['translation'])) ? $array['translation'] : '';
        $menu->description = (isset($array['description'])) ? $array['description'] : '';
        $menu->visible = (isset($array['visible'])) ? $array['visible'] : true;
        $menu->enabled = (isset($array['enabled'])) ? $array['enabled'] : true;
        $menu->acl = isset($array['acl']) ? $array['acl'] : true;
        $menu->key = $key;
        $menu->child = [];
        
        return $menu;
    }
    
    /**
     * Push menu item to given category
     * 
     * @param  string $category [Root category key]
     * @param  string $key      [Menu key]
     * @param  array $menu     [Menu contents]
     * @return void
     */
    public function push($category, $key, $menu)
    {
        if (isset($this->menu[$category])) {
            $this->menu[$category]['child'][$key] = $menu;
        }
    }
    
    /**
     * Push root menu item
     * 
     * @param  string $key    [Menu key]
     * @param  array $menu    [Menu array]
     * @return void
     */
    public function pushRoot($key, $menu)
    {
        $this->menu[$key] = $menu;
    }
    
    /**
     * Extend or add root menu category
     * 
     * @return void
     */
    protected function appendCategory($key, $menu)
    {
        if (isset($this->menu[$key])) {
            if (isset($menu['child'])) {
                $this->menu[$key]['child'] = array_merge($this->menu[$key]['child'], $menu['child']);
                unset($menu['child']);
            }
            $this->menu[$key] = array_merge($this->menu[$key], $menu);
        } else {
            $this->menu[$key] = $menu;
        }
    }
}
