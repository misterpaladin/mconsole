<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Contracts\FormConstructor;

class Forms implements GenericAPI
{
    public function __construct(FormConstructor $constructor)
    {
        $this->constructor = $constructor;
    }
}