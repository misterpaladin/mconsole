<?php

namespace Milax\Mconsole\Models;

class MconsoleDoc
{
    public $title;
    public $link;
    
    /**
     * Create new instance
     * 
     * @param string $title [Doc title]
     * @param string $link  [description]
     */
    public function __construct($title = null, $link = null)
    {
        $this->title = $title;
        $this->link = $link;
    }
}
