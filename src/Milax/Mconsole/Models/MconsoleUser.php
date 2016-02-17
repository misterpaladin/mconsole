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
		'name', 'email', 'password', 'lang',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	/**
	 * Transform updated_at proerty.
	 * 
	 * @access public
	 * @return string
	 */
	public function getUpdatedAttribute()
	{
		return $this->updated_at->format('m.d.Y');
	}
	
	public function role()
	{
		return $this->belongsTo('Milax\Mconsole\Models\MconsoleRole');
	}
	
}
