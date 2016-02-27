<?php

namespace Milax\Mconsole\Helpers;

/**
 * Class for string processing
 */
class String
{
    public $string;
    
    /**
     * Create new String instance
     * 
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }
    
    /**
     * Get string
     * 
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }
    
    /**
     * Remove quotes from string
     * 
     * @return String
     */
    public function removeQuote()
    {
        $this->string = str_replace(['\''], null, $this->string);
        return $this;
    }
    
    /**
     * Remove double quotes from string
     * 
     * @return String
     */
    public function removeDoubleQuote()
    {
        $this->string = str_replace(['""'], null, $this->string);
        return $this;
    }
    
    /**
     * Remove parenthesis from string
     * 
     * @return String
     */
    public function removeParenthesis()
    {
        $this->string = str_replace(['(', ')'], null, $this->string);
        return $this;
    }
}
