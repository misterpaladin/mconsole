<?php

namespace Milax\Mconsole\Contracts;

interface Processor
{
    /**
     * Run each item in callback function
     * 
     * @param  Closure $callback [Callback function]
     * @param  \Illuminate\Support\Collection $data     [Set of data: array, Collection, ..]
     * @return \Illuminate\Support\Collection
     */
    public function run($callback, $data);
}
