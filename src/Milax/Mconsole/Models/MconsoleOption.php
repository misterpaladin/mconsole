<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleOption extends Model
{
    use \Cacheable;
    
    public static function getByKey($key)
    {
        if ($cached = self::getCached()->where('key', $key)->first()) {
            return $cached->value;
        } else {
            return null;
        }
    }
}
