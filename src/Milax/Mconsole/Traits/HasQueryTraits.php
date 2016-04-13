<?php

namespace Milax\Mconsole\Traits;

use Milax\Mconsole\Exceptions\ModelPropertyException;
use Milax\Mconsole\Processors\TableProcessor;
use View;

trait HasQueryTraits
{
    /**
     * Run queries with HasPaginator and HasRedirects traits
     * 
     * @return
     */
    public function run($view, $cb)
    {
        // Check if $model property exists
        if (!property_exists($this, 'model')) {
            throw new ModelPropertyException('Controller must have protected $model property.');
        }
        
        // Check if $query property exists
        if (!property_exists($this, 'query')) {
            $model = $this->model;
            $this->query = $model::query();
        }
        
        // HasFilters Trait
        if (method_exists($this, 'filtrate')) {
            $this->query = $this->filtrate($this->query);
        }
        
        if (method_exists($this, 'paginate')) {
            $this->items = $this->query->paginate($this->perPage);
            View::share('paging', $this->items);
        } else {
            $this->items = $this->query->get();
        }
        
        return view($view, [
            'items' => TableProcessor::processItems($cb, $this->items),
        ]);
    }
    
    /**
     * Set query
     * 
     * @param IlluminateDatabaseEloquentBuilder $query [description]
     * 
     * @return $this
     */
    public function setQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $this->query = $query;
        return $this;
    }
}
