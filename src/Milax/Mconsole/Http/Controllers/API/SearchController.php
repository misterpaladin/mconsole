<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Handle search request
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, $namespace = null)
    {
        if (!$request->ajax()) {
            return redirect('/mconsole');
        }
        
        return app('API')->search->handle($request->query('query'), $namespace);
    }
}
