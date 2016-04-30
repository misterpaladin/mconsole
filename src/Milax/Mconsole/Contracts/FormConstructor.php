<?php

namespace Milax\Mconsole\Contracts;

interface FormConstructor
{
    /**
     * Append text input element
     * 
     * @param  string $label       [Input label]
     * @param  string $name        [Input name]
     * @param  string $placeholder [Input placeholder]
     * @param  mixed  $value       [Input value]
     * @return $this
     */
    public function appendText($label, $name, $placeholder = null, $value = null);
    
    /**
     * Append hidden input element
     * 
     * @param  string $name        [Input name]
     * @param  mixed  $value       [Input value]
     * @return $this
     */
    public function appendHidden($name, $value = null);
    
    /**
     * Append textarea element
     * 
     * @param  string $label       [Input label]
     * @param  string $name        [Input name]
     * @param  string $placeholder [Input placeholder]
     * @param  mixed  $value       [Input value]
     * @return $this
     */
    public function appendTextarea($label, $name, $placeholder = null, $value = null);
    
    /**
     * Append text input element
     * 
     * @param  string $label       [Input label]
     * @param  string $name        [Input name]
     * @param  array  $options     [Input options as 'key' => 'value' pair]
     * @param  mixed  $value       [Input value]
     * @return $this
     */
    public function appendSelect($label, $name, $options, $value = null);
    
    /**
     * Push form component to stack
     * 
     * @param  string $view    [View name]
     * @param  array  $options [View options]
     * @return $this
     */
    public function pushFormComponent($view, $options);
    
    /**
     * Render and return all stacked views
     * 
     * @return array
     */
    public function render();
}
