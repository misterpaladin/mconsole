<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        app('API')->search->register(function ($text) {
            return \App\User::select('id', 'name', 'email')->where('email', 'like', sprintf('%%%s%%', $text))->orWhere('name', 'like', sprintf('%%%s%%', $text))->get()->transform(function ($result) {
                return [
                    'title' => $result->name,
                    'description' => $result->email,
                    'link' => sprintf('/mconsole/users/%s/edit', $result->id),
                    'tags' => ['user', sprintf('#%s', $result->id)],
                ];
            });
        }, 'users');
        
        app('API')->search->register(function ($text) {
            return \Milax\Mconsole\Models\Upload::select('id', 'type', 'path', 'filename', 'copies')->where('id', (int) $text)->orWhere('filename', 'like', sprintf('%%%s%%', $text))->orderBy('type')->get()->transform(function ($result) {
                return [
                    'title' => file_get_original_name($result->filename),
                    'filepath' => $result->filename,
                    'path' => $result->path,
                    'description' => '',
                    'basepath' => '/storage/uploads',
                    'original' => $result->type == 'image' ? sprintf('/storage/uploads/%s/original/%s', $result->path, $result->filename) : sprintf('/storage/uploads/%s/%s', $result->path, $result->filename),
                    'copies' => $result->copies,
                    'preview' => $result->type == 'image' ? sprintf('/storage/uploads/%s/mconsole/%s', $result->path, $result->filename) : '',
                    'link' => '#',
                    'tags' => ['upload', $result->type, sprintf('#%s', $result->id)],
                ];
            });
        }, 'uploads');
    }
}
