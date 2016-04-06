<?php

namespace Milax\Mconsole\Contracts\API;

interface ServiceAPI
{
    public function register($args);
    public function handle($args);
}
