<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'system', 'enabled'];
    
    public function setSlugAttribute($value)
    {
        if (strlen($value) == 0) {
            $this->attributes['slug'] = str_slug($this->heading);
        } else {
            $this->attributes['slug'] = str_slug($value);
        }
    }
}
