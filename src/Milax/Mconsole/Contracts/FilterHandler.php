<?php

namespace Milax\Mconsole\Contracts;

interface FilterHandler
{
    /**
     * Handle GET query, to set builder query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handleFilterQuery($query);
    
    /**
     * Add text input filter
     * 
     * @param  string $label		Label for input
     * @param  string $key			Key of model property
     * @param  bool $exact			Set to true if input value and property value must be equal
     * @return $this
     */
    public function setText($label, $key, $exact = false);
    
    /**
     * Add select input filter
     * 
     * @param  string $label		Label for input
     * @param  string $key			Key of model property
     * @param  array $options       Options for select input
     * @param  bool $exact			Set to true if input value and property value must be equal
     * @return $this
     */
    public function setSelect($label, $key, $options, $exact = false);
    
    /**
     * Inserts new filter to filters array
     * 
     * @param  string $type			Type of input
     * @param  string $label		Label for input
     * @param  string $key			Key of model property
     * @param  bool $exact			Set to true if input value and property value must be equal
     * @param  array $options	Additional data for filter
     * @return $this
     */
    public function pushFilter($type, $label, $key, $exact = false, $options = []);
}
