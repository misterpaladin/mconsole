<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use \Cacheable, \System;
    
    protected $fillable = ['key', 'name'];
}
