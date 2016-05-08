<?php

namespace Milax\Mconsole\Traits\Controllers;

use View;

/**
 * Trait for setting page caption and action
 */
trait UseLayout
{
    /**
     * Set page caption
     * 
     * @param string $text [Page caption]
     * @return UseLayout
     */
    public function setCaption($text)
    {
        View::share('pageCaption', $text);
        return $this;
    }
    
    /**
     * Set page action
     * 
     * @param string $text [Page action]
     * @return UseLayout
     */
    public function setAction($text)
    {
        View::share('pageAction', $text);
        return $this;
    }
}
