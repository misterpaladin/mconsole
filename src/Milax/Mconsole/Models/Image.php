<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path', 'preset_id', 'filename', 'copies', 'related_id', 'related_class', 'group', 'order', 'unique', 'language_id', 'title', 'description'];
    
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
    
    /**
     * Relationship to Language
     * 
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('Milax\Mconsole\Models\Language');
    }
    
    /**
     * Automatically delete related data
     * 
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($image) {
            if (\File::exists(sprintf('%s/original/%s', $image->path, $image->filename))) {
                \File::delete(sprintf('%s/original/%s', $image->path, $image->filename));
            }
            if (\File::exists(sprintf('%s/mconsole/%s', $image->path, $image->filename))) {
                \File::delete(sprintf('%s/mconsole/%s', $image->path, $image->filename));
            }
            if ($image->copies && count($image->copies) > 0) {
                foreach ($image->copies as $copy) {
                    if (\File::exists($copy)) {
                        \File::delete($copy);
                    }
                }
            }
        });
    }
}
