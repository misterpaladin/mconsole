<?php

namespace Milax\Mconsole\Http\Middleware;

use Closure;

use Auth;

class MconsoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
// 		if (Auth::guest() || Auth::user()->type != 'admin')
// 			return abort(404);
		
        return $next($request);
    }
}
