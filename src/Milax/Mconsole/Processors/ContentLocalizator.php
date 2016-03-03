<?php

namespace Milax\Mconsole\Processors;

use Milax\Mconsole\Contracts\Localizator;

class ContentLocalizator implements Localizator
{
    public $test = 'test';
    
    public function localizePage(\Milax\Mconsole\Models\Page $page, $locale = null)
    {
        $locale = (is_null($locale)) ? config('app.locale') : $locale;
        if (empty($page->heading[$locale]) && empty($page->text[$locale])) {
            return false;
        } else {
            $page = $this->setContentLocale($page, $locale);
            return $page;
        }
    }
    
    /**
     * Check each property in object and select locale value from array
     * 
     * @param mixed $object
     * @param string $locale
     * @return mixed
     */
    protected function setContentLocale($object, $locale)
    {
        foreach (collect($object) as $key => $value) {
            if (is_array($value)) {
                $object->$key = $value[$locale];
            }
        }
        
        return $object;
    }
}
