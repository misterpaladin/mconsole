<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Milax\Mconsole\Http\Controllers\CMSController;

use Auth;

class MconsoleController extends CMSController
{
	
	protected $uri = '/mconsole';
	
	/**
	 * Display mconsole index page.
	 * 
	 * @access public
	 * @return Response
	 */
	public function index()
	{
		return $this->view('app', [
			'userName' => (Auth::check()) ? Auth::user()->name : 'Guest',
		]);
	}
	
	/**
	 * Display mconsole login page.
	 * 
	 * @access public
	 * @return Response
	 */
	public function login()
	{
		return $this->view('mconsole::auth.login');
	}
	
	/**
	 * Login attempt request.
	 * 
	 * @access public
	 * @param Request $request
	 * @return Response
	 */
	public function auth(Request $request)
	{
		if (Auth::attempt(['email' => $request->input('login'), 'password' => $request->input('password')])) {
			return ['status' => 'ok', 'location' => '/mconsole'];
		} else {
			return ['status' => 'error'];
		}
	}
	
	/**
	 * Logout.
	 * 
	 * @access public
	 * @return redirect
	 */
	public function logout()
	{
		Auth::logout();
		return redirect('/mconsole');
	}

}
