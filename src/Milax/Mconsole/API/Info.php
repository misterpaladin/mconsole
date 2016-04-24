<?php

namespace Milax\Mconsole\API;

class Info
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
