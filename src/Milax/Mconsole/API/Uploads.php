<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Http\Uploads\UploadHandler;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Models\Upload;
use File;
use Image;
use Request;
use Session;
use Cache;
use Auth;

class Uploads implements GenericAPI
{
    protected $uploadsPath;
    protected $backupName = null;
    
    public function __construct()
    {
        $this->uploadsPath = MX_UPLOADS_PATH;
        $this->requestData = Request::all();
    }
    
    /**
     * Get backup name
     *
     * @param string $group [Group name]
     * @return string
     */
    public function getBackupName($group = null)
    {
        $group = $group ? $group : Request::input('group');
        if (!$this->backupName) {
            $this->backupName = sprintf('%s_%s_%s', Auth::id(), $group, Request::server('HTTP_REFERER'));
        }
        return $this->backupName;
    }
    
    /**
     * Backup response from file uploads handler
     *
     * @param object $response [Response from upload handler]
     * @return void
     */
    public function backup($response)
    {
        if (!Cache::has($this->getBackupName())) {
            Cache::put($this->getBackupName(), [], 15);
        }
        
        Cache::put($this->getBackupName(), array_merge(Cache::get($this->getBackupName()), $response['files']), 15);
    }
    
    /**
     * Restore response from file uploads handler
     * @return array
     */
    public function restore()
    {
        if (Cache::has($this->getBackupName())) {
            $response = Cache::get($this->getBackupName());
        } else {
            $response = [];
        }
        
        return $response;
    }
    
    /**
     * Drop backup caches
     *
     * @param string $group [Group name]
     * @return void
     */
    public function dropBackup($group)
    {
        Cache::forget($this->getBackupName($group));
    }
    
    /**
     * Attach images collection to given object
     * 
     * @param  string $group   [Group name]
     * @param  Collection $files  [Files collection]
     * @param  mixed $related [Related object]
     * @param  mixed $unique [Should be unique]
     * @return mixed
     */
    public function attach($data)
    {
        if (!isset($data['uploads']) || !$data['uploads']->has($data['group'])) {
            return null;
        }
        
        $data['uploads']->get($data['group'])->each(function ($file, $key) use (&$data) {
            $file->update([
                'related_id' => $data['related']->id,
                'order' => $key,
            ]);
            if (isset($data['unique']) && $data['unique'] === true) {
                $last = $data['related']->uploads()->select('id')->where('group', $data['group'])->orderBy('id', 'desc')->first();
                if ($last) {
                    $data['related']->uploads()->where('group', $data['group'])->where('id', '!=', $last->id)->delete();
                }
            }
        });
        
        return true;
    }
    
    /**
     * Delete uploads from given object
     *
     * @param mixed $instance [Class instance]
     * @return void
     */
    public function detach($instance)
    {
        $instance->uploads->each(function ($upload) {
            $upload->delete();
        });
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
    public function get($type, $group, $class, $id, $url, $scriptURL)
    {
        $files = collect([
            'files' => collect(),
        ]);
        
        switch ($type) {
            case 'image':
                $suffix = 'original/';
                break;
            default:
                $suffix = '';
                break;
        }
        
        if ($id) {
            Upload::where('type', $type)->where('group', $group)->where('related_class', urldecode($class))->where('related_id', (int) $id)->orderBy('order')->get()->each(function ($file) use (&$suffix, &$type, &$files, &$url, &$scriptURL) {
                if (File::exists(sprintf('%s/%s/%s%s', $this->uploadsPath, $file->path, $suffix, $file->filename))) {
                    $files->get('files')->push([
                        'name' => $file->filename,
                        'type' => $file->type,
                        'language_id' => $file->language_id,
                        'title' => $file->title,
                        'description' => $file->description,
                        'size' => File::size(sprintf('%s/%s/%s%s', $this->uploadsPath, $file->path, $suffix, $file->filename)),
                        'url' => sprintf('%s%s/%s%s', $url, $file->path, $suffix, $file->filename),
                        'thumbnailUrl' => sprintf('%s%s/mconsole/%s', $url, $file->path, $file->filename),
                        'deleteUrl' => sprintf('%s%s', $scriptURL, $file->id),
                        'deleteType' => 'GET',
                    ]);
                }
            });
        }
        
        if (count($backup = $this->restore()) > 0) {
            foreach ($backup as $file) {
                $files->get('files')->push($file);
            }
        }
        
        return $files;
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
            $file = Upload::find((int) $dir);
            $file = Image::make(sprintf('%s/original/%s', $file->path, $file->filename));
        } else {
            $file = Upload::find((int) $fileID);
            $file = Image::make(sprintf('%s/%s/%s', $file->path, $dir, $file->filename));
        }
        
        header(sprintf('Content-Type: ', $file->mime()));
        echo $file->encode();
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
            'upload_dir' => storage_path('tmp/uploads/'),
            'upload_url' => '/uploads/preview/',
            'print_response' => false,
            'script_url' => mconsole_url('api/uploads/delete/'),
            'delete_type' => 'GET',
        ];
        
        $config = array_merge($defaultConfig, $config);
        
        $handler = new UploadHandler($config);
        $response = $handler->get_response();
        foreach ($response['files'] as $key => $file) {
            $response['files'][$key]->deleteUrl = sprintf('%s%s', $config['script_url'], $file->name);
        }
        
        $this->backup($response);
        
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
        Upload::destroy($id);
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
        $this->presets = MconsoleUploadPreset::getCached();
        $files = collect();
        $errors = [];
        
        if (isset($this->requestData['uploads']) && count($this->requestData['uploads']) > 0) {
            foreach ($this->requestData['uploads'] as $type => $groups) {
                foreach ($groups as $group => $input) {
                    $files->put($group, collect());
                    
                    if (!isset($input['files']) || count($input['files']) == 0) {
                        continue;
                    }
                    
                    if (is_numeric($input['preset'])) {
                        $preset = $this->presets->where('id', (int) $input['preset'])->first();
                    } else {
                        $preset = $this->presets->where('key', $input['preset'])->first();
                    }
                    
                    $model = $input['related_class'];
                    $path = sprintf('%s/%s', $this->uploadsPath, $preset->path);
                    $type = $input['type'];
                    
                    foreach ($input['files'] as $key => $file) {
                        
                        // Check if file is allowed
                        if (!in_array(pathinfo($file, PATHINFO_EXTENSION), $preset->extensions)) {
                            array_push($errors, trans('mconsole::mconsole.errors.extension', [
                                'file' => file_get_original_name($file),
                            ]));
                            continue;
                        }
                        
                        $file = sprintf('%s/%s', storage_path('tmp/uploads'), $file);
                        
                        $language = $input['language_id'][$key];
                        $title = $input['title'][$key];
                        $description = $input['description'][$key];
                        
                        File::makeDirectory($path, 0755, true, true);
                        
                        // Load image from tmp storage
                        if (File::exists($file)) {
                            $copies = [];
                            
                            switch ($type) {
                                case 'image':
                                    $copies = $this->handleImage($preset, $file, $path);
                                    break;
                                default:
                                    File::copy($file, sprintf('%s/%s', $path, basename($file)));
                                    break;
                            }
                            
                            $upload = Upload::create([
                                'preset_id' => $preset->id,
                                'language_id' => $language,
                                'title' => $title,
                                'description' => $description,
                                'group' => $group,
                                'path' => $preset->path,
                                'filename' => basename($file),
                                'related_class' => $model,
                                'copies' => $copies,
                                'type' => $type,
                            ]);
                            
                            $this->deleteTmp($file);
                        } else { // Or get Image object from database
                            $upload = Upload::where('related_class', $model)->where('filename', basename($file))->first();
                            $upload->update([
                                'language_id' => $language,
                                'title' => $title,
                                'description' => $description,
                                'type' => $type,
                            ]);
                        }
                        
                        $files->get($group)->push($upload);
                        
                        $this->dropBackup($group);
                    }
                }
            }
        }
        
        if (count($errors) > 0) {
            Session::flash('warning', $errors);
        }
        
        return $files;
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
                    $workingCopy->save($copyPath, strlen($operation['quality']) > 0 ? $operation['quality'] : 95);
                    array_push($copies, [
                        'width' => $workingCopy->width(),
                        'height' => $workingCopy->height(),
                        'path' => trim($operation['path'], '/'),
                    ]);
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
