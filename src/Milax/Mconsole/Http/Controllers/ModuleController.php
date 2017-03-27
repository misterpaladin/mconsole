<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use File;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->module = app('API')->modules->getControllerBootstrap($this);
    }
}