<?php

namespace Milax\Mconsole\Contracts;

interface DataManager
{
    /**
     * Store data in database
     * 
     * @param  array $data [Set of data]
     * @return void
     */
    public function install($data);
    
    /**
     * Remove data from database
     * 
     * @param  array $data [Set of data]
     * @return void
     */
    public function uninstall($data);
}
