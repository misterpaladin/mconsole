<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleMenu extends Model
{
	
	use \Milax\Cacheable;
	
	public function roles()
	{
		return $this->belongsToMany('Milax\Mconsole\Models\MconsoleRole', 'mconsole_roles_menus', 'role_id', 'menu_id');
	}
	
}
