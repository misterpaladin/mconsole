<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MconsoleController extends Controller
{
    protected $uri = '/mconsole';

    /**
     * Display mconsole index page.
     * 
     * @return Response
     */
    public function index()
    {
        $quote = app('API')->quotes->getRandom();
        return view('mconsole::dashboard', [
            'quote' => $quote,
        ]);
    }

    /**
     * Display mconsole login page.
     * 
     * @return Response
     */
    public function login()
    {
        return view('mconsole::auth.login');
    }

    /**
     * Login attempt request.
     * 
     * @param Request $request
     *
     * @return Response
     */
    public function auth(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('login'), 'password' => $request->input('password')])) {
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors([trans('mconsole::login.errors.password')])->withInput($request->except('password'));
        }
    }

    /**
     * Logout.
     * 
     * @return redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/mconsole');
    }
}
