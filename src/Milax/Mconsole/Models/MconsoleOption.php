<?php

namespace Milax\Mconsole\Models;

use Illuminate\Database\Eloquent\Model;

class MconsoleOption extends Model
{
    use \Cacheable;
    
    protected $fillable = ['group', 'label', 'key', 'value', 'type', 'options', 'enabled', 'rules'];
    
    protected $casts = [
        'options' => 'array',
        'rules' => 'array',
    ];
    
    /**
     * Get option value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public static function getByKey($key)
    {
        if ($option = self::getCached()->where('key', $key)->first()) {
            switch ($option->value) {
                case '1':
                    return true;
                case '0':
                    return false;
                default:
                    return $option->value;
            }
        } else {
            return null;
        }
    }
}
