<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\TagRequest;
use Milax\Mconsole\Models\Tag;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;

class TagsController extends Controller
{
    use \HasRedirects;
    
    protected $redirectTo = '/mconsole/tags';
    protected $model = 'Milax\Mconsole\Models\Tag';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form)
    {
        $this->list = $list;
        $this->form = $form;
        $this->form->addScripts([
            '/massets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js',
            '/massets/global/plugins/jquery-minicolors/jquery.minicolors.min.js',
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->list->setQuery(Tag::query())->setPerPage(20)->setAddAction('tags/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::tags.table.updated') => $item->updated_at->format('m.d.Y'),
                trans('mconsole::tags.table.name') => sprintf('<div class="label" style="background-color: %s;">%s</div>', $item->color, $item->name),
                trans('mconsole::tags.table.elements') => $item->count(),
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
        return $this->form->render('mconsole::tags.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->form->render('mconsole::tags.form', [
            'item' => Tag::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        Tag::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
    }
}
