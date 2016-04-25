<?php

namespace Milax\Mconsole\Contracts\API;

/**
 * Service APIs
 */
interface ServiceAPI
{
    public function register($args);
    public function handle($args);
}
