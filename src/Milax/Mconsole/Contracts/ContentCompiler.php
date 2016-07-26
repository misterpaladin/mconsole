<?php

namespace Milax\Mconsole\Contracts;

interface ContentCompiler
{
    /**
     * Set instance working on
     * 
     * @param Illuminate\Database\Eloquent\Model $instance
     * @return ContentCompiler
     */
    public function set($instance);
    
    /**
     * Get current instance
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function get();
    
    /**
     * Localize attributes to given language
     * 
     * @param string $lang [Locale]
     * @return ContentCompiler
     */
    public function localize($lang = null);
    
    /**
     * Render strings with Blade
     * 
     * @return ContentCompiler
     */
    public function render();
}
