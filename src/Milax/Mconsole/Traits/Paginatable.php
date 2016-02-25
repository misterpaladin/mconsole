<?php

namespace Milax\Mconsole\Traits;

use Milax\Mconsole\Processors\TableProcessor;

use View;

trait Paginatable
{
	/**
	 * Collection to hold Model items
	 * @var collection
	 */
	protected $items;
	
	/**
	 * Create view with paging and items
	 * 
	 * @param  string $view
	 * @param  function $cb
	 * @param  Illuminate\Database\Eloquent\Builder $query
	 * @return View
	 */
	protected function paginate($view, $cb, $query = null)
	{
		if (!property_exists($this, 'query')) {
			if ($query === null) {
				$model = $this->model;
				$this->query = $model::setModel(new $model);
			} else {
				$this->query = $query;
			}
		}
		
		if (method_exists($this, 'handleFilter'))
			$this->query = $this->handleFilter($this->query);
		
		$this->items = $this->query->paginate($this->perPage);
		
		View::share('paging', $this->items);
		
		return view($view, [
			'items' => TableProcessor::processItems($cb, $this->items),
		]);
	}
	
	/**
	 * Set paginator per page number
	 * 
	 * @param int $perPage
	 * @return Paginatable
	 */
	protected function setPerPage($perPage = 20)
	{
		$this->perPage = $perPage;
		return $this;
	}
	
}