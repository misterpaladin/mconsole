<?php

namespace Milax\Mconsole\Renderers;

use Milax\Mconsole\Contracts\FormRenderer;

/**
 * Standart Mconsole form wrapper
 */
class GenericFormRenderer implements FormRenderer
{
    public $args = [
        'styles' => [],
        'scripts' => [],
    ];
    
    public function addStyles($paths)
    {
        foreach ($paths as $path) {
            $this->appendPath($path, 'styles');
        }
        return $this;
    }
    
    public function addScripts($paths)
    {
        foreach ($paths as $path) {
            $this->appendPath($path, 'scripts');
        }
        return $this;
    }
    
    public function render($view, $args = [])
    {
        $this->args['content'] = view($view, $args);
        return view('mconsole::layouts.form', $this->args);
    }
    
    /**
     * Append path to given group
     * 
     * @param  string $path  [File path]
     * @param  string $group [Group name]
     * @return void
     */
    protected function appendPath($path, $group)
    {
        if (isset($this->args[$group])) {
            array_push($this->args[$group], $path);
        }
    }
}
