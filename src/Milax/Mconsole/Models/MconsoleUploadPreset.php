<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleUploadPreset extends Model
{
    use \Cacheable;
    
    protected $fillable = ['key', 'name', 'path', 'width', 'height', 'watermark', 'position', 'quality', 'extensions', 'min_width', 'min_height'];
    
    protected $casts = [
        'extensions' => 'array',
    ];
}
