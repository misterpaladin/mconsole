<?php

namespace Milax\Mconsole\Traits;

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
	 * @return View
	 */
	protected function paginate($view, $cb, $query = null)
	{
		$model = $this->model;
		
		if ($query !== null)
			$this->items = $query->paginate($this->pageLength);
		else
			$this->items = $model::paginate($this->pageLength);
		
		$items = collect();
		
		foreach ($this->items as $item) {
			$item = $cb($item);
			$cItem = collect();
			
			foreach ($item as $key => $val)
				$cItem->put($key, $val);
			
			$items->push($cItem);
		}
		
		return view($view, [
			'paging' => $this->items,
			'items' => $items,
		]);
	}
	
}