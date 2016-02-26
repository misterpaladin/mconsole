<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Milax\Mconsole\Models\MconsoleUser;

class User extends MconsoleUser
{
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
}
