<?php

namespace Milax\Mconsole\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class ToolsController extends Controller
{
    public function slug(Request $request)
    {
        return Str::slug($request->input('text'));
    }
}