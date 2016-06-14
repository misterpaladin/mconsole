<?php

namespace Milax\Mconsole\Processors;

use Milax\Mconsole\Contracts\ContentLocalizator as Repository;

class ContentLocalizator implements Repository
{
    public function localize($object, $lang = null)
    {
        $lang = is_null($lang) ? config('app.locale') : $lang;
        $attributes = $object->getAttributes();
        
        foreach ($attributes as $key => $value) {
            $value = $object->$key;
            if (is_array($value) && isset($value[$lang])) {
                $attributes[$key] = $value[$lang];
            }
        }
        
        $object->fill($attributes);
        
        return $object;
    }
}
