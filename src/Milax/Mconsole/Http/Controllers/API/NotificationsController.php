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
    public function handle()
    {
        return app('API')->notifications->get();
    }
    
    /**
     * Mark notification as seen
     */
    public function markAsSeen(Request $request, $id)
    {
        app('API')->notifications->update($id, [
            'seen' => true,
        ]);
    }
}
