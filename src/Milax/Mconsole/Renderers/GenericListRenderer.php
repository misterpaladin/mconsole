<?php

namespace Milax\Mconsole\Renderers;

use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Renderers\FilterableListRenderer;
use Milax\Mconsole\Processors\TableProcessor;
use Illuminate\Database\Eloquent\Builder;
use Milax\Mconsole\Handlers\Filters\GetFilterHandler;
use View;

class GenericListRenderer implements ListRenderer
{
    public $query;
    public $perPage = 0;
    
    public $filterHandler;
    
    public function __construct(GetFilterHandler $filterHandler)
    {
        $this->filterHandler = $filterHandler;
    }
    
    public function setText($label, $key, $exact)
    {
        return $this->filterHandler->setText($label, $key, $exact);
    }
    
    public function setSelect($label, $key, $selects, $exact)
    {
        return $this->filterHandler->setSelect($label, $key, $selects, $exact);
    }
    
    public function setQuery(Builder $query)
    {
        $this->query = $query;
        return $this;
    }
    
    public function render($view, $cb)
    {
        $this->query = $this->filterHandler->handleFilterQuery($this->query);
        
        if ($this->perPage > 0) {
            $this->items = $this->query->paginate($this->perPage);
            View::share('paging', $this->items);
        } else {
            $this->items = $this->query->get();
        }
        
        if (!View::exists($view)) {
            $add = $view;
            $view = 'mconsole::layouts.list';
            return view($view, [
                'items' => TableProcessor::processItems($cb, $this->items),
                'add' => (str_contains($add, 'mconsole')) ? $add : sprintf('/mconsole/%s', trim($add, '/')),
            ]);
        } else {
            return view($view, [
                'items' => TableProcessor::processItems($cb, $this->items),
            ]);
        }
    }
    
    public function setPerPage($perPage = 20)
    {
        $this->perPage = $perPage;
        return $this;
    }
    
    public function paginate(Builder $query)
    {
        $this->items = $this->query->paginate($this->perPage);
        return $this->items;
    }
}
