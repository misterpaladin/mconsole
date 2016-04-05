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
    public function notifications()
    {
        return app('API')->notifications->get();
    }
}
