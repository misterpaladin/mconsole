<?php

namespace Milax\Mconsole\Handlers;

use Milax\Mconsole\Contracts\PagingHandler;
use View;
use Request;

class GenericPagingHandler implements PagingHandler
{
    public $perPage;
    
    public function __construct()
    {
        $this->perPage = Request::query('perPage') ? Request::query('perPage') : 20;
    }
    
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }
    
    public function paginate($query)
    {
        $items = $query->paginate($this->perPage);
        
        View::share('paging', $items);
        
        return $items;
    }
}
