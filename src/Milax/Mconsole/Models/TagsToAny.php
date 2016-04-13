<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class TagsToAny extends Model
{
    protected $table = 'tags_to_any';
    protected $fillable = ['tag_id', 'related_id', 'related_class'];
}
