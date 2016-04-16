<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Image as ImageModel;
use Image;
use File;

class ImagesController extends Controller
{
    protected $uploadDir;
    protected $uploadUrl;
    protected $scriptUrl;
    
    public function __construct()
    {
        $this->uploadDir = storage_path('tmp/images/');
        $this->previewUrl = '/storage/images/';
        $this->scriptUrl = '/mconsole/api/images/delete/';
    }
    
    /**
     * Get all images for given model and id
     * 
     * @return Resposne
     */
    public function get(Request $request)
    {
        $input = $request->all();
        $input['related_class'] = urldecode($input['related_class']);
        return app('API')->images->get($input['group'], $input['related_class'], $input['related_id'], $this->previewUrl, $this->scriptUrl);
    }
    
    /**
     * Upload images
     * 
     * @param  Request $request
     * @return Response
     */
    public function uploadImage()
    {
        echo app('API')->images->upload();
    }
    
    /**
     * Delete image
     *
     * @param int $fileName [Image file id]
     * @return Response
     */
    public function deleteImage($id)
    {
        app('API')->images->delete($id);
    }
}
