<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Upload;
use Milax\Mconsole\Contracts\ListRenderer;

class UploadsController extends Controller
{
    use \HasRedirects;
    
    protected $redirectTo = '/mconsole/uploads';
    protected $model = 'Milax\Mconsole\Models\Upload';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->renderer->setText(trans('mconsole::uploads.filter.filename'), 'filename')
            ->setSelect(trans('mconsole::uploads.filter.type'), 'type', [
                'image' => 'Image',
                'document' => 'Document',
            ], true);
        
        return $this->renderer->setQuery(Upload::query())->setPerPage(20)->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::uploads.table.type') => $item->type,
                trans('mconsole::uploads.table.path') => $item->path,
                trans('mconsole::uploads.table.filename') => file_get_original_name($item->filename),
                trans('mconsole::uploads.table.copies') => count($item->copies),
                trans('mconsole::uploads.table.related') => strlen($item->related_class) > 0 ? sprintf('%s #%s', class_basename($item->related_class), $item->related_id) : '',
            ];
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
