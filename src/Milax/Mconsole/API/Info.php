<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;

class Info implements GenericAPI
{
    public $version;
    
    /**
     * Set App version
     *
     * @param string $version [App version]
     * @return void
     */
    public function setAppVersion($version)
    {
        $this->version = $version;
    }
    
    /**
     * Get App version
     * 
     * @return mixed
     */
    public function getAppVersion()
    {
        return $this->version;
    }
}
