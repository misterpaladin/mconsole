<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Upload;
use Image;
use File;

class FilesController extends Controller
{
    protected $uploadDir;
    protected $uploadUrl;
    protected $scriptUrl;
    
    public function __construct()
    {
        $this->uploadDir = storage_path('tmp/uploads/');
        $this->previewUrl = '/storage/images/';
        $this->scriptUrl = mconsole_url('api/uploads/delete/');
    }
    
    /**
     * Get all files for given model and id
     * 
     * @return Resposne
     */
    public function get(Request $request)
    {
        $input = $request->all();
        $input['related_class'] = urldecode($input['related_class']);
        return app('API')->files->get($input['type'], $input['group'], $input['related_class'], $input['related_id'], $this->previewUrl, $this->scriptUrl);
    }
    
    /**
     * Upload files
     * 
     * @param  Request $request
     * @return Response
     */
    public function uploadImage()
    {
        echo app('API')->files->upload();
    }
    
    /**
     * Delete image
     *
     * @param int $fileName [Image file id]
     * @return Response
     */
    public function deleteImage($id)
    {
        app('API')->files->delete($id);
    }
}
