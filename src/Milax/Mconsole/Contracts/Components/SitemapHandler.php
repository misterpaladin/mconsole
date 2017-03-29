<?php

namespace Milax\Mconsole\Contracts\Components;

interface SitemapHandler
{
    /**
     * Handle sitemap generation
     * 
     * @param Illuminate\Support\Collection $stack [SitemapItem[]]
     * @return Illuminate\Http\Response
     */
    public function handle($stack);
}
