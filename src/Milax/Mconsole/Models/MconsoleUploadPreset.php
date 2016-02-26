<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleUploadPreset extends Model
{
	
	use \Cacheable;
	
	protected $fillable = ['key', 'name', 'path', 'width', 'height', 'watermark', 'position', 'quality'];
	
	protected $casts = [
		'extensions' => 'array',
	];
	
}
