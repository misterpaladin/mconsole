<?php

namespace Milax\Mconsole\Http\Middleware;

use Closure;
use Milax\Mconsole\Contracts\Repositories\LanguagesRepository;

class LanguagesMiddleware
{
    protected $exceptions = [];
    
    /**
     * Create new instance
     */
    public function __construct(LanguagesRepository $respository)
    {
        $this->repository = $respository;
    }
    
    /**
     * Detect language by first segment,
     * 	set language or redirect to URI without first segment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $languages = $this->repository->get();
        $segments = $request->segments();
        
        $activeLang = $languages->where('key', $segments[0]);
        
        if ($activeLang->count() > 0) {
            if ($activeLang->first()->key == config('app.locale')) {
                $segments[0] = null;
                return redirect(implode('/', $segments));
            }
            \App::setLocale($activeLang->first()->key);
        }
        
        return $next($request);
    }
}
