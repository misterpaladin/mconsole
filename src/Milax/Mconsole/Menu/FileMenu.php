<?php

namespace Milax\Mconsole\Menu;

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
            'dashboard' => [
                'name' => 'mconsole::menu.dashboard.name',
                'url' => 'dashboard',
                'description' => 'menu.dashboard.description',
                'visible' => true,
                'enabled' => true,
                'acl' => false,
                'menus' => [],
            ],
            'content' => [
                'name' => 'mconsole::menu.content.name',
                'visible' => true,
                'enabled' => true,
                'menus' => [],
            ],
            'tools' => [
                'name' => 'mconsole::menu.tools.name',
                'visible' => true,
                'enabled' => true,
                'menus' => [
                    'files' => [
                        'name' => 'mconsole::menu.tools.files.name',
                        'url' => 'uploads',
                        'visible' => true,
                        'enabled' => true,
                        'menus' => [],
                    ],
                ],
            ],
            'users' => [
                'name' => 'mconsole::menu.users.name',
                'visible' => true,
                'enabled' => true,
                'menus' => [],
            ],
            'system' => [
                'name' => 'mconsole::menu.system.name',
                'visible' => true,
                'enabled' => true,
                'menus' => [],
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

        foreach ($this->menu as $key => $menu) {
            $m = $this->convert($menu, $key);
            $m->menus = collect($m->menus);
            if (isset($menu['menus'])) {
                foreach ($menu['menus'] as $cKey => $menus) {
                    $converted = $this->convert($menus, $cKey);
                    $converted->menus = collect($converted->menus);
                    if (isset($menu['menus'][$cKey]['menus'])) {
                        foreach ($menu['menus'][$cKey]['menus'] as $ccKey => $cMenus) {
                            $converted->menus->put($ccKey, $this->convert($menu['menus'][$cKey]['menus'][$ccKey], $ccKey));
                        }
                    }
                    $m->menus[$cKey] = $converted;
                }
            }
            $fileMenu->put($key, $m);
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
        $menu->name = trans($array['name']);
        $menu->url = (isset($array['url'])) ? $array['url'] : '';
        $menu->description = (isset($array['description'])) ? $array['description'] : '';
        $menu->visible = (isset($array['visible'])) ? $array['visible'] : true;
        $menu->enabled = (isset($array['enabled'])) ? $array['enabled'] : true;
        $menu->acl = isset($array['acl']) ? $array['acl'] : true;
        $menu->key = $key;
        $menu->menus = [];
        
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
        if (strlen($menu['url']) > 0) {
            $menu['url'] = sprintf('/mconsole/%s', trim($menu['url']));
        }
        
        if (str_contains($category, '.')) {
            $category = str_replace('.', '.menus.', $category) . '.menus';
            if (is_array($existed = array_get($this->menu, $category))) {
                $existed[$key] = $menu;
                array_set($this->menu, $category, $existed);
            }
        } else {
            if (isset($this->menu[$category])) {
                $this->menu[$category]['menus'][$key] = $menu;
            }
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
        if (!isset($menu['menus'])) {
            $menu['menus'] = [];
        }
        
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
            if (isset($menu['menus'])) {
                $this->menu[$key]['menus'] = array_merge($this->menu[$key]['menus'], $menu['menus']);
                unset($menu['menus']);
            }
            $this->menu[$key] = array_merge($this->menu[$key], $menu);
        } else {
            $this->menu[$key] = $menu;
        }
    }
}
