<?php

namespace Milax\Mconsole\Contracts;

interface ListRenderer
{
    /**
     * Set add button action link
     * $renderer->setAddAction(pages/create);
     * 
     * @param $this
     */
    public function setAddAction($action);
    
    /**
     * Remove add button action
     * $renderer->removeAddAction();
     * 
     * @return $this
     */
    public function removeAddAction();
    
    /**
     * Remove edit button action
     * $renderer->removeEditAction();
     * 
     * @return $this
     */
    public function removeEditAction();
    
    /**
     * Remove delete button action
     * $renderer->removeDeleteAction();
     * 
     * @return $this
     */
    public function removeDeleteAction();
    
    /**
     * Add text input filter
     * 
     * @param  string $label		Label for input
     * @param  string $key			Key of model property
     * @param  bool $exact			Set to true if input value and property value must be equal
     * @return $this
     */
    public function setText($label, $key, $exact = false);
    
    /**
     * Add select input filter
     * 
     * @param  string $label		Label for input
     * @param  string $key			Key of model property
     * @param  array $selects
     * @param  bool $exact			Set to true if input value and property value must be equal
     * @return $this
     */
    public function setSelect($label, $key, $selects, $exact = false);
    
    /**
     * Set query
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query [description]
     * @return $this
     */
    public function setQuery(\Illuminate\Database\Eloquent\Builder $query);
    
    /**
     * Run queries, process items with callback and return view
     *
     * @param Closure $cb [Callback function]
     * @param mixed $view [View name]
     * @return View
     */
    public function render($cb, $view = null);
    
    /**
     * Set paginator per page number
     * 
     * @param int $perPage
     * @return $this
     */
    public function setPerPage($items = 20);
    
    /**
     * Create view with paging and items
     * 
     * @param  string $view
     * @param  function $cb
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return View
     */
    public function paginate(\Illuminate\Database\Eloquent\Builder $query);
}
