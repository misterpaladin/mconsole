<?php

namespace Milax\Mconsole\Traits;

use Milax\Mconsole\Processors\TableProcessor;

trait HasPaginator
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
    protected function paginate($query)
    {
        $this->items = $this->query->paginate($this->perPage);
        return $this->items;
    }
    
    /**
     * Set paginator per page number
     * 
     * @param int $perPage
     * @return HasPaginator
     */
    protected function setPerPage($perPage = 20)
    {
        $this->perPage = $perPage;
        return $this;
    }
}
