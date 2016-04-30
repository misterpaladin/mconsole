<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use \HasState;
    
    protected $fillable = ['key', 'name', 'tree', 'state', 'system'];
    
    protected $casts = [
        'tree' => 'array',
    ];
}
