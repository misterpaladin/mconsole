<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class APIController extends Controller
{
    /**
     * Get user notifications
     * 
     * @return Response
     */
    public function getNotifications()
    {
        return app('API')->notifications->get();
    }
    
    /**
     * See notification
     * 
     * @param  int $id [Notification id]
     * @return void
     */
    public function seeNotification($id)
    {
        app('API')->notifications->update($id, [
            'seen' => true,
        ]);
    }
}
