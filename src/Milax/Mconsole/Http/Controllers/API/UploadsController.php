<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;

class UploadsController extends Controller
{
    protected $uploadDir;
    protected $uploadUrl;
    protected $scriptUrl;
    
    public function __construct()
    {
        $this->uploadDir = storage_path('tmp/uploads/');
        $this->previewUrl = '/storage/images/';
        $this->scriptUrl = '/mconsole/api/uploads/delete/';
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
        return app('API')->uploads->get($input['type'], $input['group'], $input['related_class'], $input['related_id'], $this->previewUrl, $this->scriptUrl);
    }
    
    /**
     * Upload images
     * 
     * @param  Request $request
     * @return Response
     */
    public function upload()
    {
        echo app('API')->uploads->upload();
    }
    
    /**
     * Delete image
     *
     * @param int $fileName [Image file id]
     * @return Response
     */
    public function delete($id)
    {
        app('API')->uploads->delete($id);
    }
}
