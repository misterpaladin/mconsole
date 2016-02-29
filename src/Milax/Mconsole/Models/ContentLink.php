<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class ContentLink extends Model
{
    protected $fillable = ['page_id', 'url', 'title', 'order', 'enabled'];
    
    /**
     * Page relationship
     * 
     * @return Illuminate\Eloquent\Relatios\HasOne
     */
    protected function page()
    {
        return $this->hasOne('Milax\Mconsole\Models\Page', 'id', 'page_id');
    }
}
