<?php

namespace Milax\Mconsole\Http\Middleware;

use Closure;
use Auth;

class MconsoleMiddleware
{
    protected $exceptions = [];
    
    /**
     * Create new instance
     */
    public function __construct()
    {
        $id = Auth::id();
        
        // Add some exceptions
        array_push($this->exceptions, sprintf('GET:%s', mconsole_url('/', true)));
        array_push($this->exceptions, sprintf('GET:%s', mconsole_url('dashboard', true)));
        array_push($this->exceptions, sprintf('GET:%s', mconsole_url('api/search', true)));
        array_push($this->exceptions, sprintf('GET:%s/%s/edit', mconsole_url('users', true), $id));
        array_push($this->exceptions, sprintf('PUT:%s/%s', mconsole_url('users', true), $id));
        array_push($this->exceptions, sprintf('POST:%s/%s/menus', mconsole_url('users', true), $id));
    }
    
    /**
     * Check for mconsole access.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Redirect if already authenticated
        if ($request->is(mconsole_url('login', true)) && Auth::user() && Auth::user()->role_id > 0) {
            return redirect(mconsole_url('/'));
        }
        
        // Redirect to login page
        if ((Auth::guest() || Auth::user()->role_id == 0) && !$request->is(mconsole_url('login', true))) {
            return redirect(mconsole_url('login'));
        }
        
        // Set user locale if authenticated
        if (Auth::check()) {
            app('API')->translations->setUserLocale();
        }
        
        if (!$request->is(mconsole_url('login', true)) && Auth::user()->role->key != 'root') {
            if (!$this->hasAccess($request)) {
                return response()->view('mconsole::errors.accessdenied');
            }
        }
        
        return $next($request);
    }
    
    /**
     * Check if user has access to given route
     * 
     * @param  Request  $request
     * @return boolean
     */
    protected function hasAccess($request)
    {
        $uri = sprintf('%s:%s', $request->method(), $request->route()->getUri());
        $path = sprintf('%s:%s', $request->method(), $request->path());
        
        if ($request->is(mconsole_url('logout', true))) {
            return true;
        }
        
        $method = $request->method();
        
        // Allow everyone to visit dashboard
        if (in_array($uri, $this->exceptions) || in_array($path, $this->exceptions)) {
            return true;
        }
        
        $user = Auth::user();
        
        // Check if route is in user allowed routes
        $routes = $user->role->routes;
        
        if (count($routes) == 0) {
            return false;
        }
        
        if (in_array($uri, $routes)) {
            return true;
        }
        
        return false;
    }
}
