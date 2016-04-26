<?php

namespace Milax\Mconsole\Contracts;

interface FormRenderer
{
    /**
      * Include a set of stylesheets files
      * 
      * @param array $paths [Paths to .css files]
      * @return $this
      */
    public function addStyles($paths);
    
    /**
     * Include a set javascripts files
     * 
     * @param array $paths [Paths to .js files]
     * @return $this
     */
    public function addScripts($paths);
    
    /**
     * Render form inside mconsole wrapper
     * Should also render styles and scripts
     * 
     * @param  string $view       [View name]
     * @param  string $args [View parameters]
     * @return View
     */
    public function render($view, $args = []);
}
