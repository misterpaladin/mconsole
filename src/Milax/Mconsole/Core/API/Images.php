<?php

namespace Milax\Mconsole\Core\API;

use Milax\Mconsole\Http\UploadHandler;
use Milax\Mconsole\Models\Image as ImageModel;
use File;
use Image;
use Request;
use Milax\Mconsole\Models\MconsoleUploadPreset;

class Images
{
    protected $uploadables = 'uploadable';
    protected $files;
    protected $imagesPath;
    
    public function __construct()
    {
        $this->imagesPath = storage_path('app/public/images');
        $this->request = Request::all();
        $this->presets = MconsoleUploadPreset::getCached();
    }
    
    /**
     * Attach images collection to given object
     * 
     * @param  string $group   [Group name]
     * @param  Collection $images  [Images collection]
     * @param  mixed $related [Related object]
     * @param  mixed $unique [Should be unique]
     * @return mixed
     */
    public function attach($data)
    {
        if (!$data['images']->has($data['group'])) {
            return null;
        }
        
        $data['images']->get($data['group'])->each(function ($image, $key) use (&$data) {
            $image->update([
                'related_id' => $data['related']->id,
                'order' => $key,
            ]);
            if (isset($data['unique']) && $data['unique'] === true) {
                $last = $data['related']->images()->select('id')->where('group', $data['group'])->orderBy('id', 'desc')->first();
                $data['related']->images()->where('group', $data['group'])->where('id', '!=', $last->id)->delete();
            }
        });
        
        return true;
    }
    
    /**
     * Get images for given group, class and id
     * 
     * @param  string $group [Group name]
     * @param  string $class [Related class name]
     * @param  int    $id    [Related object id]
     * @param  string $url   [Prefix URL]
     * @return Illuminate\Support\Collection
     */
    public function get($group, $class, $id, $url, $scriptURL)
    {
        $images = collect([
            'files' => collect(),
        ]);
        ImageModel::where('group', $group)->where('related_class', $class)->where('related_id', (int) $id)->orderBy('order')->get()->each(function ($image) use (&$images, &$url, &$scriptURL) {
            if (File::exists(sprintf('%s/%s/original/%s', $this->imagesPath, $image->path, $image->filename))) {
                $images->get('files')->push([
                    'name' => $image->filename,
                    'language_id' => $image->language_id,
                    'title' => $image->title,
                    'description' => $image->description,
                    'size' => File::size(sprintf('%s/%s/original/%s', $this->imagesPath, $image->path, $image->filename)),
                    'url' => sprintf('%s%s/original/%s', $url, $image->path, $image->filename),
                    'thumbnailUrl' => sprintf('%s%s/mconsole/%s', $url, $image->path, $image->filename),
                    'deleteUrl' => sprintf('%s%s', $scriptURL, $image->id),
                    'deleteType' => 'GET',
                ]);
            }
        });
        
        return $images;
    }
    
    /**
     * Get image preview
     * 
     * @param  string $dir    [Directory OR filename]
     * @param  string $fileID [Optional filename if directory is set]
     * @return mixed
     */
    public function preview($dir, $fileID = null)
    {
        if (is_null($fileID)) {
            $image = ImageModel::find((int) $dir);
            $image = Image::make(sprintf('%s/original/%s', $image->path, $image->filename));
        } else {
            $image = ImageModel::find((int) $fileID);
            $image = Image::make(sprintf('%s/%s/%s', $image->path, $dir, $image->filename));
        }
        
        header(sprintf('Content-Type: ', $image->mime()));
        echo $image->encode();
    }
    
    /**
     * Handle images upload to tmp directory
     *
     * @param array $config [Override uploader library config]
     * @return string
     */
    public function upload($config = [])
    {
        $defaultConfig = [
            'upload_dir' => storage_path('tmp/images/'),
            'upload_url' => '/images/preview/',
            'print_response' => false,
            'script_url' => '/mconsole/api/images/delete/',
            'delete_type' => 'GET',
        ];
        
        $config = array_merge($defaultConfig, $config);
        
        $handler = new UploadHandler($config);
        $response = $handler->get_response();
        foreach ($response['files'] as $key => $file) {
            $response['files'][$key]->deleteUrl = sprintf('%s%s', $config['script_url'], $file->name);
        }
        return json_encode($response);
    }
    
    /**
     * Delete image by given id
     * 
     * @param  int $id [Image id]
     * @return void
     */
    public function delete($id)
    {
        ImageModel::destroy($id);
    }
    
    /**
     * Register callback handler
     * 
     * @return void
     */
    public function handle($closure)
    {
        $closure($this->handleUpload());
    }
    
    /**
     * Find and process files from request.
     * 
     * @access protected
     * @return void
     */
    protected function handleUpload()
    {
        // Get request from app container
        // $request = app('Milax\Mconsole\Http\Requests\UploadableRequest');

        $images = collect();
        
        if (isset($this->request['uploadable'])) {
            foreach ($this->request['uploadable'] as $group => $input) {
                $images->put($group, collect());
                
                if (!isset($input['files']) || count($input['files']) == 0) {
                    break;
                }
                
                $preset = $this->presets->where('key', $input['preset'])->first();
                $model = $input['related_class'];
                $path = sprintf('%s/%s', $this->imagesPath, $preset->path);
                
                foreach ($input['files'] as $key => $file) {
                    $file = sprintf('%s/%s', storage_path('tmp/images'), $file);
                    
                    $language = $input['language_id'][$key];
                    $title = $input['title'][$key];
                    $description = $input['description'][$key];
                    
                    // Load image from tmp storage
                    if (File::exists($file)) {
                        $copies = $this->handleImage($preset, $file, $path);
                        
                        $image = ImageModel::create([
                            'preset_id' => $preset->id,
                            'language_id' => $language,
                            'title' => $title,
                            'description' => $description,
                            'group' => $group,
                            'path' => $preset->path,
                            'filename' => basename($file),
                            'related_class' => $model,
                            'copies' => $copies,
                        ]);
                        
                        $this->deleteTmp($file);
                    } else { // Or get Image object from database
                        $image = ImageModel::where('preset_id', $preset->id)->where('related_class', $model)->where('filename', basename($file))->first();
                        $image->update([
                            'language_id' => $language,
                            'title' => $title,
                            'description' => $description,
                        ]);
                    }
                    
                    $images->get($group)->push($image);
                }
            }
        }
        
        return $images;
    }
    
    /**
     * Delete uploaded files from tmp
     * 
     * @param  string $file [Full path to file
     * @return void
     */
    protected function deleteTmp($file)
    {
        if (File::exists($file)) {
            File::delete($file);
        }
        foreach (File::directories(pathinfo($file, PATHINFO_DIRNAME)) as $subDir) {
            if (File::exists(sprintf('%s/%s', $subDir, basename($file)))) {
                File::delete(sprintf('%s/%s', $subDir, basename($file)));
            }
        }
    }
    
    /**
     * Handle image processing
     * 
     * @param  Milax\Mconsole\Models\MconsoleUploadPreset $preset [Upload preset]
     * @param  string $file   [Full file path]
     * @param  string $path   [Base path]
     * 
     * @return array         [Copies array]
     */
    protected function handleImage($preset, $file, $path)
    {
        File::makeDirectory($path, 0755, true, true);
        File::makeDirectory(sprintf('%s/original', $path), 0755, true, true);
        File::makeDirectory(sprintf('%s/mconsole', $path), 0755, true, true);
        
        Image::make($file)->fit(50, 50, function ($constraint) {
            $constraint->upsize();
        })->save(sprintf('%s/mconsole/%s', $path, basename($file)));
        $original = Image::make($file)->save(sprintf('%s/original/%s', $path, basename($file)));
        $workingCopy = clone($original);
        
        $copies = [];
        
        foreach ($preset->operations as $operation) {
            switch ($operation['operation']) {
                case 'original':
                    $workingCopy = clone($original);
                    break;
                
                case 'save':
                    $saveTo = sprintf('%s/%s', $path, trim($operation['path'], '/'));
                    File::makeDirectory($saveTo, 0755, true, true);
                    $copyPath = sprintf('%s/%s', $saveTo, basename($file));
                    $workingCopy->save($copyPath, $operation['quality']);
                    array_push($copies, sprintf('%s/%s/%s', $preset->path, trim($operation['path'], '/'), basename($file)));
                    break;
                
                case 'resize':
                    switch ($operation['type']) {
                        case 'ratio':
                            $workingCopy->resize($operation['width'], $operation['height'], function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            break;
                        case 'center':
                            $workingCopy->fit($operation['width'], $operation['height'], function ($constraint) {
                                $constraint->upsize();
                            });
                            break;
                        case 'fixed':
                            if ($workingCopy->width() >= $workingCopy->height()) {
                                $width = $operation['width'];
                                $height = null;
                            } else {
                                $width = null;
                                $height = $operation['height'];
                            }
                            
                            $workingCopy->resize($width, $height, function ($constraint) {
                                $constraint->aspectRatio();
                            })->resizeCanvas($operation['width'], $operation['height'], 'center');
                            break;
                    }
                    break;
                
                case 'greyscale':
                    $workingCopy->greyscale();
                    break;
            }
        }
        
        return $copies;
    }
}
