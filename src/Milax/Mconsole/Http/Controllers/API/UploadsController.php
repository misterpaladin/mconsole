<?php

namespace Milax\Mconsole\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Cache;
use Auth;

class UploadsController extends Controller
{
    protected $uploadDir;
    protected $uploadUrl;
    protected $scriptUrl;
    
    public function __construct(Request $request)
    {
        $this->uploadDir = storage_path('tmp/uploads/');
        $this->previewUrl = '/storage/uploads/';
        $this->scriptUrl = '/mconsole/api/uploads/delete/';
        
        $user = Auth::id();
        $group = $request->input('group');
        $referer = $request->server('HTTP_REFERER');
        $this->cacheName = sprintf('%s%s%s', $user, $group, $referer);
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
    
    public function restore()
    {
        if (Cache::has($this->cacheName)) {
            $backup = Cache::get($this->cacheName);
        } else {
            $backup = [];
        }
        return ['files' => $backup];
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
        
        if (!Cache::has($this->cacheName)) {
            Cache::put($this->cacheName, [], 15);
        }
        
        Cache::put($this->cacheName, array_merge(Cache::get($this->cacheName), json_decode($files)->files), 15);
        
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
