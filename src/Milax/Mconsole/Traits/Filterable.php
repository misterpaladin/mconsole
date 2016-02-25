<?php

namespace Milax\Mconsole\Traits;

use View;
use Request;

use Milax\Mconsole\Exceptions\FiltersPropertyException;
use Milax\Mconsole\Processors\TableProcessor;

trait Filterable
{
	
	/**
	 * Start model filtration
	 * 
	 * @param  string $view
	 * @param  function $cb
	 * @param  Illuminate\Database\Eloquent\Builder $query
	 * @return View
	 */
	protected function filtrate($view, $cb, $query = null)
	{
		$adaptor->adapt($this);
		if (!property_exists($this, 'query')) {
			if ($query === null) {
				$model = $this->model;
				$this->query = $model::getQuery();
			} else {
				$this->query = $query;
			}
		}
		
		if (!method_exists($this, 'paginate')) {
			$this->handleFilter();
			return view($view, [
				'items' => TableProcessor::processItems($cb, $this->items),
			]);
		} else {
			return $this->paginate($view, $cb, $query);
		}
	}
	/**
	 * Start filtration process
	 * 
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	protected function handleFilter()
	{
		// Ensure that $this->query property has a query
		if (!property_exists($this, 'query')) {
			$model = $this->model;
			$this->query = $model::getQuery();
		}
		
		// Check if filters is set and have valid type
		if (property_exists($this, 'filters'))
			if (is_array($this->filters) && count($this->filters) > 0)
				$this->handleQuery();
			else
				throw new FiltersPropertyException('$filters property must be array.');
		else
			throw new FiltersPropertyException('You must set protected $filters property in your controller.');
		
		return $this->query;
		
	}
	
	/**
	 * Add text input filter
	 * 
	 * @param  string $label		Label for input
	 * @param  string $key			Key of model property
	 * @param  bool $exact			Set to true if input value and property value must be equal
	 * @return Filterable
	 */
	protected function setText($label, $key, $exact)
	{
		return $this->pushFilter('text', $label, $key, $exact);
	}
	
	/**
	 * Add select input filter
	 * 
	 * @param  string $label		Label for input
	 * @param  string $key			Key of model property
	 * @param  array $selects
	 * @param  bool $exact			Set to true if input value and property value must be equal
	 * @return Filterable
	 */
	protected function setSelect($label, $key, $selects, $exact)
	{
		return $this->pushFilter('select', $label, $key, $exact, $selects);
	}
	
	/**
	 * Handle GET query, to set builder query
	 * 
	 * @return void
	 */
	private function handleQuery()
	{
		$filtered = false;
		foreach ($this->filters as $filter) {
			if (Request::query($filter['key'])) {
				$filtered = true;
				if ($filter['exact'])
					$this->query->where($filter['key'], Request::query($filter['key']));
				else
					$this->query->where($filter['key'], 'like', '%' . Request::query($filter['key']) . '%');
			}
		}
		
		// Avoid collision with Paginatable trait
		if (!method_exists($this, 'handleItems')) {
			$this->items = $this->query->get();
			View::share('items', $this->items);
		}
		
		View::share('filtered', $filtered);
		View::share('filterable', $this->filters);
		
	}
	
	/**
	 * Inserts new filter to filters array
	 * 
	 * @param  string $type			Type of input
	 * @param  string $label		Label for input
	 * @param  string $key			Key of model property
	 * @param  bool $exact			Set to true if input value and property value must be equal
	 * @param  array $options	Additional data for filter
	 * @return Filterable
	 */
	private function pushFilter($type, $label, $key, $exact, $options = [])
	{
		$filter = [
			'type' => $type,
			'label' => $label,
			'key' => $key,
			'exact' => $exact,
		];
		
		if ($options)
			$filter['options'] = $options;
		
		$this->filters[] = $filter;
		
		return $this;
	}
	
}