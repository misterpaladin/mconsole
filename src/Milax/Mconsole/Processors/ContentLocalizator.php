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
            $hasLanguages = false;
            $value = $object->$key;
            if (is_array($value)) {
                if (isset($value[$lang])) {
                    $hasLanguages = true;
                }
            } else {
                $value = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if (isset($value[$lang])) {
                        $hasLanguages = true;
                    }
                }
            }
            
            if ($hasLanguages) {
                $attributes[$key] = $value[$lang];
            }
        }
        
        $object->fill($attributes);
        
        return $object;
    }
}
