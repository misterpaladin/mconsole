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
        //
    }
    
    public function register()
    {
        //
    }
}
