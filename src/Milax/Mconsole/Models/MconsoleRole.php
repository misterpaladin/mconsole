<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;
use Milax\Mconsole\Adapters\PermissionsAdapter;

class MconsoleRole extends Model
{
	protected $fillable = ['name'];
	
	public function menus()
	{
		return $this->belongsToMany('Milax\Mconsole\Models\MconsoleMenu', 'mconsole_roles_menus', 'role_id', 'route');
	}
	
	public function users()
	{
		return $this->hasMany('App\User', 'role_id');
	}
	
}
