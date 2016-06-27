<?php

namespace Milax\Mconsole\Contracts;

interface LanguageManager
{
    /**
     * Detect and set current language
     * @return void
     */
    public function setLanguage();
    
    /**
     * Redirect if language is default
     * @return Redirector
     */
    public function defaultLanguageRedirect();
    
    /**
     * Get active language prefix
     * @return string
     */
    public function getLanguagePrefix();
}