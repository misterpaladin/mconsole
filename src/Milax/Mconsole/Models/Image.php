<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path', 'preset_id', 'filename', 'copies', 'related_id', 'related_class'];
    
    protected $casts = [
        'copies' => 'array',
    ];
    
    /**
     * Relationship to MconsoleUploadPreset
     *
     * @return BelongsTo
     */
    public function preset()
    {
        return $this->belongsTo('Milax\Mconsole\Models\MconsoleUploadPreset', 'preset_id');
    }
}
