<?php

namespace Milax\Mconsole\Core\Menu;

use Milax\Mconsole\Contracts\Menu;

class FileMenu implements Menu
{
    protected $model = '\Milax\Mconsole\Models\MconsoleMenu';
    
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
                        'translation' => 'menu.users.list.name',
                        'url' => 'users',
                        'description' => 'menu.users.list.description',
                        'route' => 'mconsole.users.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'users_create' => [
                        'name' => 'Create user',
                        'translation' => 'menu.users.create.name',
                        'url' => 'users/create',
                        'description' => 'menu.users.create.description',
                        'route' => 'mconsole.users.create',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'users_update' => [
                        'name' => 'Edit users',
                        'translation' => 'menu.users.update.name',
                        'description' => 'menu.users.update.description',
                        'route' => 'mconsole.users.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'users_delete' => [
                        'name' => 'Delete users',
                        'translation' => 'menu.users.delete.name',
                        'description' => 'menu.users.delete.description',
                        'route' => 'mconsole.users.destroy',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_all' => [
                        'name' => 'All roles',
                        'translation' => 'menu.roles.list.name',
                        'url' => 'roles',
                        'description' => 'menu.roles.list.description',
                        'route' => 'mconsole.roles.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'roles_create' => [
                        'name' => 'Create role',
                        'translation' => 'menu.roles.create.name',
                        'url' => 'roles/create',
                        'description' => 'menu.roles.create.description',
                        'route' => 'mconsole.roles.create',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_update' => [
                        'name' => 'Edit roles',
                        'translation' => 'menu.roles.update.name',
                        'description' => 'menu.roles.update.description',
                        'route' => 'mconsole.roles.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'roles_delete' => [
                        'name' => 'Delete roles',
                        'translation' => 'menu.roles.delete.name',
                        'description' => 'menu.roles.delete.description',
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
                        'translation' => 'menu.presets.list.name',
                        'url' => 'presets',
                        'description' => 'menu.presets.list.description',
                        'route' => 'mconsole.presets.index',
                        'visible' => true,
                        'enabled' => true,
                    ],
                    'presets_form' => [
                        'name' => 'Create preset',
                        'translation' => 'menu.presets.form.name',
                        'url' => 'presets/create',
                        'description' => 'menu.presets.form.description',
                        'route' => 'mconsole.presets.store',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'presets_update' => [
                        'name' => 'Edit presets',
                        'translation' => 'menu.presets.update.name',
                        'description' => 'menu.presets.update.description',
                        'route' => 'mconsole.presets.edit',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'presets_delete' => [
                        'name' => 'Delete presets',
                        'translation' => 'menu.presets.delete.name',
                        'description' => 'menu.presets.delete.description',
                        'route' => 'mconsole.presets.destroy',
                        'visible' => false,
                        'enabled' => true,
                    ],
                    'manage_modules' => [
                        'name' => 'Manage modules',
                        'translation' => 'menu.modules.name',
                        'url' => 'modules',
                        'description' => 'menu.modules.description',
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
        
        foreach (app('Mconsole')->modules['installed'] as $module) {
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
    public function appendCategory($key, $menu)
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
