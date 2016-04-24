<?php

namespace Milax\Mconsole\Docs;

use Parsedown;
use Milax\Mconsole\Models\MconsoleDoc;

class DocsParser
{
    protected $parser;
    
    /**
     * Create new instance
     *
     * @param Parsedown $parser [Parsedown instance]
     */
    public function __construct(Parsedown $parser)
    {
        $this->parser = $parser;
    }
    
    /**
     * Parse markdown, replace links
     *
     * @param string $md [Markdown string]
     * @return string
     */
    public function parseMarkdown($md)
    {
        return $this->parser->text($md);
    }
    
    /**
     * Scan directory for markdown files
     * 
     * @param  string $dir [Path to directory]
     * @return array
     */
    public function scanDocs($dir)
    {
        $files = [];
        $locale = app()->getLocale();
        foreach (glob(sprintf('%s/%s/*.md', rtrim($dir, '/'), $locale)) as $file) {
            $doc = new MconsoleDoc();
            $doc->title = pathinfo($file, PATHINFO_FILENAME);
            $doc->link = str_replace(' ', '-', pathinfo($file, PATHINFO_FILENAME));
            array_push($files, $doc);
        }
        return $files;
    }
}
