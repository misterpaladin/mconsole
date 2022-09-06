<?php

namespace Milax\Mconsole\Processors;

use Milax\Mconsole\Contracts\ContentLocalizator as Repository;
use Milax\Mconsole\Models\Compiled;
use Arr;

class ContentLocalizator implements Repository
{
    public function localize($object, $lang = null)
    {
        $lang = is_null($lang) ? config('app.locale') : $lang;
        $attributes = $object->getAttributes();
        $compiled = new Compiled;
        
        foreach ($attributes as $key => $value) {
            $hasLanguages = false;
            $value = $object->$key;
            
            switch (gettype($value)) {
                case 'array':
                    if (Arr::has($value, $lang)) {
                        $hasLanguages = true;
                    }
                    break;
                case 'string':
                    $value = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (Arr::has(is_array($value) ? $value : [$value], $lang)) {
                            $hasLanguages = true;
                        }
                    }
                    break;
                default:
                    break;
            }
            
            if ($hasLanguages) {
                if (!is_array($value[$lang]) && strlen($value[$lang]) == 0) {
                    $compiled->$key = null;
                } else {
                    $compiled->$key = $value[$lang];
                }
            }
        }

        return $compiled;
    }
}
