<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class MconsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('mconsole::app');
    }
    
    public function login()
    {
	    return view('mconsole::auth.login');
    }
    
    public function auth(Request $request)
    {
	    if (Auth::attempt(['email' => $request->input('login'), 'password' => $request->input('password')])) {
            return ['status' => 'ok', 'location' => '/mconsole'];
        } else {
	        return ['status' => 'error'];
        }
    }
    
    public function logout()
    {
	    Auth::logout();
	    return redirect('/mconsole');
    }

}
