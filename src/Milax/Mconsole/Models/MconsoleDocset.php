<?php

namespace Milax\Mconsole\Models;

class MconsoleDocset
{
    public $title;
    public $description;
    public $docs = [];
    
    /**
     * Create new instance
     * @param string $title [Title of docset]
     * @param array $docs  [Docs]
     */
    public function __construct($docs = [], $title = null, $description = null)
    {
        $this->title = $title;
        $this->docs = $docs;
        $this->description = $description;
    }
}
