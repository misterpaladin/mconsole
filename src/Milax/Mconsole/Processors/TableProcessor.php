<?php

namespace Milax\Mconsole\Processors;

class TableProcessor
{
	/**
	 * Process callbacks for Filterable and Paginatable traits
	 * 
	 * @param  function $cb
	 * @param  Collection $items
	 * @return Collection
	 */
	public static function processItems($cb, $items)
	{
		$collection = collect();
		
		foreach ($items as $item) {
			$item = $cb($item);
			$cItem = collect();
			
			foreach ($item as $key => $val)
				$cItem->put($key, $val);
			
			$collection->push($cItem);
		}
		
		return $collection;
	}
	
}