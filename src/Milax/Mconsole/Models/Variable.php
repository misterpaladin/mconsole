<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
	
	use \Milax\Cacheable;
	
	protected $fillable = ['key', 'value', 'description'];
	
}
