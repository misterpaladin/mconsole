<?php

namespace Milax\Mconsole\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class MconsoleUser extends Authenticatable
{
	
	protected $table = 'users';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function role()
	{
		return $this->belongsTo('Milax\Mconsole\Models\MconsoleRole');
	}
	
}
