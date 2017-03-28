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
     * @param  string $label		[Label for input]
     * @param  string $key			[Key of model property]
     * @param  bool $exact			[Set to true if input value and property value must be equal]
     * @return $this
     */
    public function setText($label, $key, $exact = false);
    
    /**
     * Add select input filter
     * 
     * @param  string $label		[Label for input]
     * @param  string $key			[Key of model property]
     * @param  array $selects
     * @param  bool $exact			[Set to true if input value and property value must be equal]
     * @return $this
     */
    public function setSelect($label, $key, $selects, $exact = false);
    
    /**
     * Add date picker filter
     * 
     * @param  string $label		[Label for input]
     * @param  string $key			[Key of model property]
     * @return $this
     */
    public function setDate($label, $key);
    
    /**
     * Add date range picker filter
     * 
     * @param  string $label		[Label for input]
     * @param  string $key			[Key of model property]
     * @return $this
     */
    public function setDateRange($label, $key);
    
    /**
     * Set query
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query [description]
     * @return $this
     */
    public function setQuery($query);
    
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
    public function setPerPage($perPage);
    
    /**
     * Create view with paging and items
     * 
     * @param  string $view
     * @param  function $cb
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return View
     */
    public function paginate($query);
    
    /**
     * Append partial before list
     * 
     * @param \Illuminate\View\View $view
     * @return $this
     */
    public function before($view);

    /**
     * Append partial after list
     * 
     * @param \Illuminate\View\View $view
     * @return $this
     */
    public function after($view);
}
