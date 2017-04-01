<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;

class SitemapManager implements GenericAPI
{
    protected $stack = [];
    
    /**
     * Register links provider.
     * 
     * @access public
     * @param Closure $handler
     * @return $this
     */
    public function register($handler)
    {
        array_push($this->stack, $handler);
        return $this;
    }
    
    /**
     * Register sitemap handler.
     * 
     * @access public
     * @param \Milax\Mconsole\Contracts\Components\SitemapHandler $handler
     * @return void
     */
    public function setHandler(\Milax\Mconsole\Contracts\Components\SitemapHandler $handler)
    {
        $this->handler = $handler;
    }
    
    /**
     * Handle sitemap generation.
     * 
     * @access public
     * @return \Illuminate\Http\Response
     */
    public function handle()
    {
        return $this->handler->handle($this->stack);
    }
}