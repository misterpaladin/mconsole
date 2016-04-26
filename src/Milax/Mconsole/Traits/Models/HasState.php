<?php

namespace Milax\Mconsole\Traits\Models;

trait HasState
{
    /**
     * Scope enabled elements
     * 
     * @param  \Illuminate\Database\Query\Builder $query [Query]
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
    
    /**
     * Scope disabled elements
     * 
     * @param  \Illuminate\Database\Query\Builder $query [Query]
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeDisabled($query)
    {
        return $query->where('enabled', false);
    }
}
