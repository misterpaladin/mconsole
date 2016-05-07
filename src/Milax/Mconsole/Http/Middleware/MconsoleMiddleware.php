<?php

namespace Milax\Mconsole\Http\Middleware;

use Closure;
use Auth;

class MconsoleMiddleware
{
    protected $exceptions = [
        'GET:mconsole',
        'GET:mconsole/dashboard',
        'GET:mconsole/api/search',
    ];
    
    /**
     * Create new instance
     */
    public function __construct()
    {
        $id = Auth::id();
        
        // User profile exception
        array_push($this->exceptions, sprintf('GET:mconsole/users/%s', $id));
        array_push($this->exceptions, sprintf('GET:mconsole/users/%s/edit', $id));
        array_push($this->exceptions, sprintf('POST:mconsole/users/%s/menus', $id));
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
        if ($request->is('mconsole/login') && Auth::user() && Auth::user()->role_id > 0) {
            return redirect('/mconsole');
        }
        
        // Redirect to login page
        if ((Auth::guest() || Auth::user()->role_id == 0) && !$request->is('mconsole/login')) {
            return redirect('/mconsole/login');
        }
        
        // Set user locale if authenticated
        if (Auth::check()) {
            app('API')->translations->setUserLocale();
        }
        
        if (!$request->is('mconsole/login') && Auth::user()->role->key != 'root') {
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
        
        if ($request->is('mconsole/logout')) {
            return true;
        }
        
        $user = Auth::user();
        
        $method = $request->method();
        
        // Allow everyone to visit dashboard
        if (in_array($uri, $this->exceptions)) {
            return true;
        }
        
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
