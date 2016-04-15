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
            if (count($option->options) >= 2) {
                if (isset($option->options[0]) && isset($option->options[1])) {
                    switch ($option->value) {
                        case '1':
                            return true;
                        case '0':
                            return false;
                    }
                } else {
                    return $option->value;
                }
            } else {
                if (is_array($option->rules) && in_array('integer', $option->rules)) {
                    return (int) $option->value;
                } else {
                    return $option->value;
                }
            }
        } else {
            return null;
        }
    }
}
