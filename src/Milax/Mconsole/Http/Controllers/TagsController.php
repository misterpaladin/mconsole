<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\TagRequest;
use Milax\Mconsole\Models\Tag;

class TagsController extends Controller
{
    use \HasQueryTraits, \HasRedirects;
    
    protected $redirectTo = '/mconsole/tags';
    protected $model = 'Milax\Mconsole\Models\Tag';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->run('mconsole::tags.list', function ($item) {
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
        return view('mconsole::tags.form');
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
        return view('mconsole::tags.form', [
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
