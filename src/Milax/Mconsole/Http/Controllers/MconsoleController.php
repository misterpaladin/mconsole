<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MconsoleController extends Controller
{
    use \UseLayout;
    
    protected $uri = '/mconsole';

    /**
     * Display mconsole index page.
     * 
     * @return Response
     */
    public function index()
    {
        $this->setCaption(trans('mconsole::mconsole.headings.main'));
        $this->setAction(trans('mconsole::mconsole.text.welcome'));
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
