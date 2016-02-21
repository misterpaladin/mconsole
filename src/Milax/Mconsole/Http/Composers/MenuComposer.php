<?php

namespace Milax\Mconsole\Http\Composers;

use Illuminate\View\View;

use Milax\Mconsole\Models\MconsoleMenu;

class MenuComposer
{
	
	/**
	 * Compose mconsole menu tree.
	 * 
	 * @access public
	 * @param View $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$all = MconsoleMenu::getCached();
		$menu = $all->where('menu_id', 0);
		$menu->each(function ($parent) use (&$all) {
			$parent->child = $all->where('menu_id', $parent->id);
		});
		
		$view->with('mconsole_menu', $menu);
	}
	
}