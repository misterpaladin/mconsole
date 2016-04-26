<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Linkable extends Model
{
    protected $fillable = ['link_id', 'linkable_id', 'linkable_type'];
    
    /**
     * Relation to Link
     * 
     * @return BelongsTo
     */
    public function link()
    {
        return $this->belongsTo('Milax\Mconsole\Models\Link');
    }
}
