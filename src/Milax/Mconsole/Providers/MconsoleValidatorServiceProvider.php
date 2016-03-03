<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Image;
use Validator;
use Request;

class MconsoleValidatorServiceProvider extends ServiceProvider
{
    protected $request;
    protected $translator;
    protected $errors;
    
    /**
     * Define custom validator extensions.
     * 
     * @access public
     * @return bool
     */
    public function boot()
    {
        $this->app['translator']->addNamespace('mconsole', __DIR__.'/../../../resources/lang');
        
        // Validate required presets field
        Validator::extend('presets_required', function ($attribute, $value, $parameters, $validator) {
            
            if (!Request::has('uploadable')) {
                return false;
            }
            
            foreach (Request::input('uploadable') as $uploadable) {
                if (count($uploadable['presets']) == 0) {
                    false;
                }
            }
            
            return true;
            
        }, trans('mconsole::rv.presets.required'));
        
        // Validate file extensions
        Validator::extend('presets_extensions', function ($attribute, $value, $parameters, $validator) {
            
            $valid = true;
            
            if (Request::has('uploadable')) {
                foreach (Request::input('uploadable') as $key => $uploadable) {
                    // Get selected presets
                    $presets = MconsoleUploadPreset::getCached()->filter(function ($preset) use (&$uploadable) {
                        foreach ($uploadable['presets'] as $presetInput) {
                            if ($presetInput == $preset->id) {
                                return true;
                            }
                        }
                    });
                    
                    // Filter presets by file extensions
                    $match = 0;
                    foreach ($presets as $preset) {
                        if (in_array($value->getClientOriginalExtension(), json_decode($preset->extensions))) {
                            $match++;
                        }
                    }
                    if ($match != count($uploadable['presets'])) {
                        $valid = false;
                    }
                }
            }
            
            return $valid;
            
        });
        
        Validator::replacer('presets_extensions', function ($attribute, $value, $parameters, $validator) {
            return trans('mconsole::rv.presets.extensions', ['file' => Request::file($value)->getClientOriginalName()]);
        });
        
        // Validate images size
        Validator::extend('presets_image_size', function ($attribute, $value, $parameters, $validator) {
            $valid = true;
            foreach (Request::input('uploadable') as $key => $uploadable) {
                $presets = $uploadable['presets'];
                foreach ($presets as $preset) {
                    $preset = MconsoleUploadPreset::getCached()->where('id', (int) $preset)->first();
                    $image = Image::make($value);
                    if ($preset->min_width > $image->width() || $preset->min_height > $image->height()) {
                        $valid = false;
                    }
                }
            }
            
            return $valid;
        });
        
        Validator::replacer('presets_image_size', function ($attribute, $value, $parameters, $validator) {
            return trans('mconsole::rv.presets.imagesize', ['file' => Request::file($value)->getClientOriginalName()]);
        });
    }
    
    public function register()
    {
        //
    }
}
