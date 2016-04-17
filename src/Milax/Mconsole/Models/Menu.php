<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'tree', 'state', 'system'];
    
    protected $casts = [
        'tree' => 'array',
    ];
}
