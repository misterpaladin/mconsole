<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	
	protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'system', 'enabled'];
	
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
	
}
