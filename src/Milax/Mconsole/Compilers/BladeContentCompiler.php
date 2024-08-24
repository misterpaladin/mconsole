<?php

namespace Milax\Mconsole\Compilers;

use Milax\Mconsole\Contracts\ContentCompiler;
use Milax\Mconsole\Contracts\ContentLocalizator;
use Milax\Mconsole\Models\Compiled;
use Milax\Mconsole\Blade\BladeRenderer;

class BladeContentCompiler implements ContentCompiler
{
    protected $instance;
    protected $lang;
    protected $localizator;
    
    public function __construct(ContentLocalizator $localizator)
    {
        $this->localizator = $localizator;
    }
    
    public function set($instance)
    {
        $this->instance = $instance;
        $this->instance->compiled = new Compiled;
        return $this;
    }
    
    public function get()
    {
        return $this->instance;
    }
    
    public function localize($lang = null)
    {
        $this->instance->compiled = $this->localizator->localize($this->instance, $lang);
        return $this;
    }
    
    public function render()
    {
        $attributes = $this->instance->getAttributes();
        
        foreach ($attributes as $key => $value) {
            if (property_exists($this->instance->compiled, $key) && is_null($this->instance->compiled->$key)) {
                continue;
            }
            
            if (is_string($value)) {
                if (!isset($this->instance->compiled->$key)) {
                    $this->instance->compiled->$key = (new BladeRenderer($value))->render()->render();
                } else {
                    $this->instance->compiled->$key = (new BladeRenderer($this->instance->compiled->$key))->render()->render();
                }
            }
        }
        
        return $this;
    }
}
