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
     * Remove mconsole uploads suffix from filename
     * 
     * @return string
     */
    public function getOriginalFileName()
    {
        $errname = [];
        $errname['original'] = $this->string;
        $errname['extension'] = pathinfo($errname['original'], PATHINFO_EXTENSION);
        $errname['exploded'] = explode('-', $errname['original']);
        array_pop($errname['exploded']);
        $errname['final'] = implode('-', $errname['exploded']);
        return sprintf('%s.%s', $errname['final'], $errname['extension']);
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
