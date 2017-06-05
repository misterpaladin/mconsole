<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Upload;
use Milax\Mconsole\Models\Language;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\Contracts\Repositories\UploadsRepository;
use Milax\Mconsole\Contracts\Repositories\PresetsRepository;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow, \UseLayout;
    
    protected $model = 'Milax\Mconsole\Models\Upload';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $renderer, FormRenderer $form, UploadsRepository $repository, PresetsRepository $presetsRepository)
    {
        $this->setCaption(trans('mconsole::uploads.menu.name'));
        $this->renderer = $renderer;
        $this->form = $form;
        $this->repository = $repository;
        $this->presets = $presetsRepository;
        
        $this->redirectTo = mconsole_url('uploads');
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
        
        return $this->renderer->setQuery($this->repository->index())->before(view('mconsole::uploads.list-form', [
            'presets' => $this->presets->get(),
        ]))->render(function ($item) {
            $copies = collect($item->getCopies(true));

            $copies = $copies->transform(function ($copy, $key) {
                return '<button class="copy btn btn-default btn-xs" data-clipboard-text="' . $copy . '" target="_blank">' . $key . '</button>';
            })->implode(' ');

            return [
                trans('mconsole::tables.id') => $item->id,
                trans('mconsole::uploads.table.type') => $item->type,
                trans('mconsole::uploads.table.path') => $item->path,
                trans('mconsole::uploads.table.filename') => file_get_original_name($item->filename),
                trans('mconsole::uploads.table.copies') => $copies,
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
    public function store(Request $request)
    {
        $this->handleUploads();
        
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->form->render('mconsole::uploads.form', [
            'item' => $this->repository->find($id),
            'languages' => Language::getCached()->pluck('name', 'id')->prepend(trans('mconsole::uploader.all'), 0)->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $upload = $this->repository->find($id);
        
        app('API')->tags->sync($upload);
        
        $this->repository->update($id, $request->all());
        
        $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        app('API')->uploads->delete($id);
        $this->redirect();
    }
    
    /**
     * Handle files upload
     *
     * @return void
     */
    protected function handleUploads()
    {
        // Images processing
        app('API')->uploads->handle(function ($uploads) {
            app('API')->uploads->attach([
                'group' => 'upload',
                'uploads' => $uploads,
                'related' => null,
            ]);
            foreach ($uploads->get('upload') as $upload) {
                app('API')->tags->sync($upload);
            }
        });
    }
}
