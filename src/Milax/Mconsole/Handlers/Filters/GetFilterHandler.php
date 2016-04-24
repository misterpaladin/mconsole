<?php

namespace Milax\Mconsole\Handlers\Filters;

use Milax\Mconsole\Contracts\FilterHandler;
use Milax\Mconsole\Exceptions\FiltersPropertyException;
use View;
use Request;

class GetFilterHandler implements FilterHandler
{
    protected $filters = [];
    
    public function handleFilterQuery($query)
    {
        $filtered = false;
        
        foreach ($this->filters as $filter) {
            if (Request::has($filter['key']) && Request::query($filter['key']) != -1) {
                $filtered = true;
                if ($filter['exact']) {
                    $query->where($filter['key'], Request::query($filter['key']));
                } else {
                    $query->where($filter['key'], 'like', '%' . Request::query($filter['key']) . '%');
                }
            }
        }
        
        View::share('filtered', $filtered);
        View::share('filters', $this->filters);
        
        return $query;
    }
    
    public function setText($label, $key, $exact = false)
    {
        return $this->pushFilter('text', $label, $key, $exact);
    }
    
    public function setSelect($label, $key, $options, $exact = false)
    {
        return $this->pushFilter('select', $label, $key, $exact, $options);
    }
    
    public function pushFilter($type, $label, $key, $exact = false, $options = [])
    {
        $filter = [
            'type' => $type,
            'label' => $label,
            'key' => $key,
            'exact' => $exact,
        ];
        
        if ($options) {
            $filter['options'] = $options;
        }
        
        $this->filters[] = $filter;
        
        return $this;
    }
}
