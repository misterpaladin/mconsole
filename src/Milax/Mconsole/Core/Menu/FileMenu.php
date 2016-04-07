<?php

namespace Milax\Mconsole\Core\Menu;

use Milax\Mconsole\Contracts\Menu;

class FileMenu implements Menu
{
    protected $model = '\Milax\Mconsole\Models\MconsoleMenu';
    
    /**
     * Create new class instance, define menu
     */
    public function __construct()
    {
        $this->menu = [
            'content' => [
                'name' => 'Content',
                'key' => 'content',
                'translation' => 'menu.content.name',
                'visible' => true,
                'enabled' => true,
                'child' => [],
            ],
            'users' => [
                'name' => 'Users',
                'key' => 'users',
                'translation' => 'menu.users.name',
                'visible' => true,
                'enabled' => true,
                'child' => [
                    'users_all' => [
                        'name' => 'All users',
                        'translation' => 'users.menu.list.name',
                        'url' => 'users',
                        'description' => 'users.menu.list.description',
                        'route' => 'mconsole.users.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'users_create' => [
                        'name' => 'Create user',
                        'translation' => 'users.menu.create.name',
                        'url' => 'users/create',
                        'description' => 'users.menu.create.description',
                        'route' => 'mconsole.users.create',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'users_update' => [
                        'name' => 'Edit users',
                        'translation' => 'users.menu.update.name',
                        'description' => 'users.menu.update.description',
                        'route' => 'mconsole.users.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'users_delete' => [
                        'name' => 'Delete users',
                        'translation' => 'users.menu.delete.name',
                        'description' => 'users.menu.delete.description',
                        'route' => 'mconsole.users.destroy',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_all' => [
                        'name' => 'All roles',
                        'translation' => 'roles.menu.list.name',
                        'url' => 'roles',
                        'description' => 'roles.menu.list.description',
                        'route' => 'mconsole.roles.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'roles_create' => [
                        'name' => 'Create role',
                        'translation' => 'roles.menu.create.name',
                        'url' => 'roles/create',
                        'description' => 'roles.menu.create.description',
                        'route' => 'mconsole.roles.create',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_update' => [
                        'name' => 'Edit roles',
                        'translation' => 'roles.menu.update.name',
                        'description' => 'roles.menu.update.description',
                        'route' => 'mconsole.roles.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_delete' => [
                        'name' => 'Delete roles',
                        'translation' => 'roles.menu.delete.name',
                        'description' => 'roles.menu.delete.description',
                        'route' => 'mconsole.roles.destroy',
                        'visible' => false,
                        'enabled' => true,
                    ],
                ],
            ],
            'tools' => [
                'name' => 'Tools',
                'key' => 'tools',
                'translation' => 'menu.tools.name',
                'visible' => true,
                'enabled' => true,
                'child' => [
                    'presets_all' => [
                        'name' => 'Presets',
                        'translation' => 'presets.menu.list.name',
                        'url' => 'presets',
                        'description' => 'presets.menu.list.description',
                        'route' => 'mconsole.presets.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'presets_form' => [
                        'name' => 'Create preset',
                        'translation' => 'presets.menu.create.name',
                        'url' => 'presets/create',
                        'description' => 'presets.menu.create.description',
                        'route' => 'mconsole.presets.create',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'presets_update' => [
                        'name' => 'Edit presets',
                        'translation' => 'presets.menu.update.name',
                        'description' => 'presets.menu.update.description',
                        'route' => 'mconsole.presets.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'presets_delete' => [
                        'name' => 'Delete presets',
                        'translation' => 'presets.menu.delete.name',
                        'description' => 'presets.menu.delete.description',
                        'route' => 'mconsole.presets.destroy',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'manage_modules' => [
                        'name' => 'Manage modules',
                        'translation' => 'modules.menu.name',
                        'url' => 'modules',
                        'description' => 'modules.menu.description',
                        'route' => 'mconsole.modules.index',
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
        
        foreach ($this->menu as $menu) {
            $m = $this->convert($menu);
            if (isset($menu['child'])) {
                foreach ($menu['child'] as $child) {
                    $m->child[] = $this->convert($child);
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
    protected function convert($array)
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
        $menu->route = (isset($array['route'])) ? $array['route'] : '';
        $menu->child = [];
        
        return $menu;
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
