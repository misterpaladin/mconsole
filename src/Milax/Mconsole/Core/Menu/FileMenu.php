<?php

namespace Milax\Mconsole\Core\Menu;

use Milax\Mconsole\Contracts\Menu;

class FileMenu implements Menu
{
	
	protected $path;
	protected $model = '\Milax\Mconsole\Models\MconsoleMenu';
	
	public function __construct()
	{
		$this->path = 'mconsole.menu';
	}
	
	/**
	 * Load menu from configuration file
	 * 
	 * @return Illuminate\Support\Collection
	 */
	public function load()
	{
		$fileMenu = collect();
		$config = config($this->path);
		foreach ($config as $menu) {
			$fileMenu->push($this->convert($menu));
			if (isset($menu['child']))
				foreach ($menu['child'] as $child)
					$fileMenu->push($this->convert($child));
		}
		
		return $fileMenu;
	}
	
	protected function convert($array)
	{
		$properties = get_class_vars(__CLASS__);
		$menu = new $properties['model'];
		
		$menu->menu_id = (isset($array['menu_id'])) ? $array['menu_id'] : 0;
		$menu->name = (isset($array['name'])) ? $array['name'] : '';
		$menu->key = (isset($array['key'])) ? $array['key'] : '';
		$menu->url = (isset($array['url'])) ? $array['url'] : '';
		$menu->translation = (isset($array['translation'])) ? $array['translation'] : '';
		$menu->description = (isset($array['description'])) ? $array['description'] : '';
		$menu->visible = (isset($array['visible'])) ? $array['visible'] : true;
		$menu->enabled = (isset($array['enabled'])) ? $array['enabled'] : true;
		$menu->route = (isset($array['route'])) ? $array['route'] : '';
		
		return $menu;
	}
	
}