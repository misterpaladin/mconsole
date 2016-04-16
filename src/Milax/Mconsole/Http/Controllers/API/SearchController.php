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
    public function handle(Request $request)
    {
        return app('API')->search->handle($request->query('query'));
    }
    
    /**
     * Mark notification as seen
     */
    public function markAsSeen($id)
    {
        app('API')->notifications->update($id, [
            'seen' => true,
        ]);
    }
}
