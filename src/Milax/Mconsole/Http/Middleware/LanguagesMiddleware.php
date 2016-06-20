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
        
        if ($request->query('lang')) {
            if ($activeLang = $languages->where('key', $request->query('lang'))->first()) {
                if ($activeLang->key == config('app.locale')) {
                    return redirect($request->path());
                }
                \App::setLocale($activeLang->key);
            } else {
                return redirect($request->path());
            }
        }
        
        return $next($request);
    }
}
