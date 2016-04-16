<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    /**
     * Handle notifications request
     * 
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/mconsole');
        }
        
        return app('API')->notifications->get();
    }
    
    /**
     * Mark notification as seen
     */
    public function markAsSeen(Request $request, $id)
    {
        if (!$request->ajax()) {
            return redirect('/mconsole');
        }
        
        app('API')->notifications->update($id, [
            'seen' => true,
        ]);
    }
}
