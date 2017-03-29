<?php

namespace Milax\Mconsole\Models;

class SitemapItem
{
    public $path = null;
    public $changefreq = null;
    public $lastmod = null;
    public $priority = null;

    /**
     * Create new instance
     * 
     * @param string $path
     * @param string $changefreq
     * @param DateTime $lastmod
     * @param float $priority
     */
    public function __construct($path, $changefreq = null, $lastmod = null, $priority = null)
    {
        $this->path = $path;
        $this->changefreq = $changefreq;
        $this->lastmod = $lastmod;
        $this->priority = $priority;
    }
}