<?php

namespace Milax\Mconsole\Contracts;

interface PagingHandler
{
    /**
     * Set per page items
     *
     * @param int $perPage [Number]
     * @return $this
     */
    public function setPerPage($perPage);
    
    /**
     * Execute paginate query
     * 
     * @param  \Illuminate\Database\Query\Builder $query [Query instance]
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function paginate($query);
}
