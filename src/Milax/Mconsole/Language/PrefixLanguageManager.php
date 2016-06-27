<?php 

namespace Milax\Mconsole\Language;

use Request;
use Milax\Mconsole\Contracts\LanguageManager;
use Milax\Mconsole\Contracts\Repositories\LanguagesRepository;

class PrefixLanguageManager implements LanguageManager
{
    protected $defaultLang;
    protected $lang;
    
    /**
     * Create new instance
     */
    public function __construct(LanguagesRepository $respository)
    {
        $this->repository = $respository;
        $this->defaultLang = $this->lang = config('app.locale');
        $this->setLanguage();
    }
    
    /**
     * Detect language by first segment
     *
     * @return void
     */
    public function setLanguage()
    {
        $languages = $this->repository->get();
        $segments = Request::segments();
        
        if (count($segments) > 0 ) {    
            $activeLang = $languages->where('key', $segments[0]);
            if ($activeLang->count() > 0) {
                $this->lang = $activeLang->first()->key;
                
                \App::setLocale($this->lang);
            }
        }
    }
    
    public function defaultLanguageRedirect()
    {
        $segments = Request::segments();
        
        if ($segments[0] == $this->lang && $this->lang == $this->defaultLang) {
            \Route::any('/{lang}/{slug?}', function () use ($segments) {
                $segments[0] = null;
                return redirect(implode('/', $segments));
            })->where('slug', '.*');
        }
    }
    
    public function getLanguagePrefix()
    {
        return $this->lang != $this->defaultLang ? $this->lang : '';
    }
}