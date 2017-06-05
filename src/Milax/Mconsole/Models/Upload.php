<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use \HasTags;
    
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
     * Get image url for given copy
     * 
     * @param  string $size
     * @return string
     */
    public function getImagePath($size = 'original')
    {
        return sprintf('/storage/uploads/%s/%s/%s', $this->path, $size, $this->filename);
    }

    /**
     * Get document url for given copy
     * 
     * @return string
     */
    public function getDocumentPath()
    {
        return sprintf('/storage/uploads/%s/%s', $this->path, $this->filename);
    }

    /**
     * Get original file path
     *
     * @return string
     */
    public function getOriginalPath($size = 'original')
    {
        switch ($this->type) {
            case 'image':
                return $this->getImagePath($size);
            
            default:
                return $this->getDocumentPath();
        }
    }
    
    /**
     * Undocumented function
     *
     * @param boolean $includeOriginal [Include original file path]
     * @return void
     */
    public function getCopies($includeOriginal = false)
    {
        $copies = [];
        
        foreach ($this->copies as $copy) {
            $copies[$copy['path']] = $this->getImagePath($copy['path']);
        }
        
        if ($includeOriginal) {
            $copies['original'] = $this->getOriginalPath();
        }

        return $copies;
    }

    // @TODO: REMOVE THIS METHOD
    public function getImageCopies()
    {
        throw new \Milax\Mconsole\Exceptions\DeprecatedException('Upload getImageCopies is deprecated, use getCopies() instead');
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
