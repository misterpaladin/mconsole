<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Providers\MconsoleServiceProvider;
use Milax\Mconsole\Models\Language;
use File;
use Schema;

class Translations
{
    protected $provider;
    
    /**
     * Create new class instance
     * 
     * @param MconsoleServiceProvider $provider [Mconsole service provider]
     */
    public function __construct(MconsoleServiceProvider $provider)
    {
        $this->provider = $provider;
    }
    
    /**
     * Load and merge translations
     * 
     * @return void
     */
    public function load()
    {
        if (!File::exists(storage_path('app/lang'))) {
            File::makeDirectory(storage_path('app/lang'), 0777, true, true);
        }
        
        if (!Schema::hasTable(Language::getQuery()->from)) {
            return;
        }
        
        $languages = Language::getCached();
        
        // Collect translation files
        foreach ($this->provider->translations as $translation) {
            foreach (glob($translation . '/*/*.php') as $lg) {
                foreach ($languages as $language) {
                    if (File::exists($translation . '/'. $language->key . '/' . basename($lg))) {
                        // Create if language directory is not exists
                        if (!File::exists(storage_path('app/lang/' . $language->key))) {
                            File::makeDirectory(storage_path('app/lang/' . $language->key), 0777, true, true);
                        }
                        
                        // Copy new or merge existing translation file
                        if (File::exists(storage_path('app/lang/' . $language->key . '/' . basename($lg)))) {
                            $baseLang = include storage_path('app/lang/' . $language->key . '/' . basename($lg));
                            $customLang = include sprintf('%s/%s/%s', $translation, $language->key, basename($lg));
                            if (is_array($baseLang)) {
                                $baseLang = array_merge($baseLang, $customLang);
                            } else {
                                $baseLang = $customLang;
                            }
                            File::put(storage_path('app/lang/' . $language->key . '/' . basename($lg)), '<?php return ' . var_export($baseLang, true) . ';');
                        } else {
                            File::copy($lg, storage_path('app/lang/' . $language->key . '/' . basename($lg)));
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Set Application locale for current user settings
     */
    public function setUserLocale($locale = null)
    {
        if (!is_null($locale)) {
            return \App::setLocale($locale);
        }
        
        if (strlen($lang = \Auth::user()->lang) > 0) {
            \App::setLocale($lang);
        }
    }
}
