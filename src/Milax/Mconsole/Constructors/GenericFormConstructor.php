<?php

namespace Milax\Mconsole\Constructors;

use Milax\Mconsole\Contracts\FormConstructor;

class GenericFormConstructor implements FormConstructor
{
    public $views = [];
    
    public function appendText($label, $name, $placeholder = null, $value = null)
    {
        $this->pushFormComponent('mconsole::forms.text', [
            'label' => $label,
            'name' => $name,
        ]);
        return $this;
    }
    
    public function appendHidden($name, $value = null)
    {
        $this->pushFormComponent('mconsole::forms.hidden', [
            'name' => $name,
            'value' => $value,
        ]);
        return $this;
    }
    
    public function appendTextarea($label, $name, $placeholder = null, $value = null)
    {
        $this->pushFormComponent('mconsole::forms.textarea', [
            'label' => $label,
            'name' => $name,
            'placeholder' => $placeholder,
            'value' => $value,
        ]);
        return $this;
    }
    
    public function appendSelect($label, $name, $options, $value = null)
    {
        $this->pushFormComponent('mconsole::forms.select', [
            'label' => $label,
            'name' => $name,
            'options' => $options,
            'value' => $value,
        ]);
    }
    
    public function pushFormComponent($view, $options)
    {
        array_push($this->views, view($view, $options));
        return $this;
    }
    
    public function render()
    {
        return view('mconsole::forms.constructor', [
            'views' => $this->views,
        ]);
    }
}
