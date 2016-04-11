<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use \Cacheable;
    
    protected $fillable = ['key', 'name'];
}
