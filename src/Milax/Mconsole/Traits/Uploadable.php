<?php

namespace Milax\Mconsole\Traits;

use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Http\Requests\UploadableRequest;
use Validator;
use Image;
use Request;
use Storage;

trait Uploadable
{
    protected $uploadables = 'uploadable';
    
    /**
     * Initialize object.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $files = Request::capture()->files;
        if ($files->has('uploadable') && $files->get('uploadable')[0]['files'][0] !== null) {
            $this->presets = MconsoleUploadPreset::getCached();
            $this->handleUpload();
        }
    }
    
    /**
     * Find and process files from request.
     * 
     * @access public
     * @param Request $request
     * @return void
     */
    public function handleUpload()
    {
        // Get request from app container
        $request = app('Milax\Mconsole\Http\Requests\UploadableRequest');
        
        dd($request);
        
        $response->each(function ($presets, $fileKey) {
            $file = $this->images[$fileKey];
            $fileName = md5(time() . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $presets->each(function ($preset) use (&$file, &$fileName) {
                
                Storage::makeDirectory('public/images/' . $preset->path);
                
                Image::make($file)->save(storage_path('app/public/images/') . $fileName)->fit($preset->width, $preset->height, function ($constraint) {
                    $constraint->upsize();
                })->save(storage_path('app/public/images/') . $preset->path . '/' . $fileName);
            });
        });
        
        return true;
    }
}
