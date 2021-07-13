<?php

namespace Milax\Mconsole\Handlers\Filters;

use Milax\Mconsole\Contracts\FilterHandler;
use Milax\Mconsole\Exceptions\FiltersPropertyException;
use View;
use Request;
use Carbon\Carbon;

class GetFilterHandler implements FilterHandler
{
    protected $filters = [];
    
    public function handleFilterQuery($query)
    {
        $filtered = false;
        
        foreach ($this->filters as $filter) {
            if (Request::has($filter['key']) && Request::query($filter['key']) != -1 && Request::query($filter['key']) !== null) {
                $filtered = true;
                switch ($filter['type']) {
                    case 'date':
                        if (Request::query($filter['key'])) {
                            $from = Carbon::createFromFormat('Y-m-d', Request::query($filter['key']))->startOfDay();
                            $to = Carbon::createFromFormat('Y-m-d', Request::query($filter['key']))->endOfDay();
                            $query = $query->where($filter['key'], '>=', $from)->where($filter['key'], '<=', $to);
                        }
                        break;
                    
                    case 'daterange':
                        $query = $query->where($filter['key'], '>=', array_get(Request::query($filter['key']), 'from'))->where($filter['key'], '<=', array_get(Request::query($filter['key']), 'to'));
                        break;
                    
                    default:
                        if ($filter['exact']) {
                            $query = $query->where($filter['key'], Request::query($filter['key']));
                        } else {
                            $query = $query->where($filter['key'], 'like', '%' . Request::query($filter['key']) . '%');
                        }
                        break;
                }
            }
        }
        
        if (!defined('FILTERS_ACTIVE')) {
            define('FILTERS_ACTIVE', $filtered);
        }
        
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
    
    public function setDate($label, $key)
    {
        return $this->pushFilter('date', $label, $key);
    }
    
    public function setDateRange($label, $key)
    {
        return $this->pushFilter('daterange', $label, $key);
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
