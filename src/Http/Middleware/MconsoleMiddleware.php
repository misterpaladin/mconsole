<?php

namespace Milax\Mconsole\Http\Middleware;

use Closure;

use Auth;

class MconsoleMiddleware
{
    /**
     * Check for mconsole access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    /** Redirect if already authenticated */
	    if ($request->is('mconsole/login') && Auth::user() && Auth::user()->admin)
	    	return redirect('/mconsole');
	    
	    /** Redirect to login page */
		if ((Auth::guest() || !Auth::user()->admin) && !$request->is('mconsole/login'))
			return redirect('/mconsole/login');
		
        return $next($request);
    }
}
