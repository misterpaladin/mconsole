<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleUploadPreset extends Model
{
    use \Cacheable;
    
    protected $fillable = ['operations', 'key', 'name', 'path', 'width', 'height', 'watermark', 'position', 'quality', 'extensions', 'min_width', 'min_height'];
    
    protected $casts = [
        'extensions' => 'array',
        'operations' => 'array',
    ];
    
    /**
     * Relationship to Image
     * 
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany('Milax\Mconsole\Models\Image', 'preset_id');
    }
}
