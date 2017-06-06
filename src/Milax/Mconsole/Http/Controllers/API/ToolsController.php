<?php

namespace Milax\Mconsole\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function slug(Request $request)
    {
        return str_slug($request->input('text'));
    }
}