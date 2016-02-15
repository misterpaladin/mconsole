<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MconsoleRole extends Model
{
	protected $fillable = ['name'];
	
	public function menus()
	{
		return $this->belongsToMany('App\MconsoleMenu', 'mconsole_roles_menus', 'role_id', 'menu_id');
	}
	
	public function users()
	{
		return $this->hasMany('App\User');
	}
	
}
