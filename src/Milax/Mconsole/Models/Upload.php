<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['type', 'path', 'preset_id', 'filename', 'copies', 'related_id', 'related_class', 'group', 'order', 'unique', 'language_id', 'title', 'description'];
    
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
        static::deleting(function ($file) {
            if (\File::exists(sprintf('%s/%s/%s', MX_UPLOADS_PATH, $file->path, $file->filename))) {
                \File::delete(sprintf('%s/%s/%s', MX_UPLOADS_PATH, $file->path, $file->filename));
            }
            if (\File::exists(sprintf('%s/%s/original/%s', MX_UPLOADS_PATH, $file->path, $file->filename))) {
                \File::delete(sprintf('%s/%s/original/%s', MX_UPLOADS_PATH, $file->path, $file->filename));
            }
            if (\File::exists(sprintf('%s/%s/mconsole/%s', MX_UPLOADS_PATH, $file->path, $file->filename))) {
                \File::delete(sprintf('%s/%s/mconsole/%s', MX_UPLOADS_PATH, $file->path, $file->filename));
            }
            if ($file->copies && count($file->copies) > 0) {
                foreach ($file->copies as $copy) {
                    if (\File::exists(sprintf('%s/%s/%s/%s', MX_UPLOADS_PATH, $file->path, $copy['path'], $file->filename))) {
                        \File::delete(sprintf('%s/%s/%s/%s', MX_UPLOADS_PATH, $file->path, $copy['path'], $file->filename));
                    }
                }
            }
        });
    }
}
