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
    protected $previewUrl;
    
    public function __construct(Request $request)
    {
        $this->uploadDir = storage_path('tmp/uploads/');
        $this->previewUrl = '/storage/uploads/';
        $this->scriptUrl = mconsole_url('api/uploads/delete/', false);
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
        $files = app('API')->uploads->upload();
        echo $files;
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
