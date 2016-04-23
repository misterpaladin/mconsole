<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MenuRequest;
use Milax\Mconsole\Models\Menu;
use ListRenderer;

class MenusController extends Controller
{
    use \HasRedirects;
    
    protected $model = 'Milax\Mconsole\Models\Menu';
    protected $redirectTo = '/mconsole/menus';
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
        return $this->renderer->setQuery(Menu::query())->setPerPage(20)->setAddAction('menus/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::menus.table.name') => $item->name,
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
        return view('mconsole::menu.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        Menu::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('mconsole::menu.form', [
            'item' => Menu::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        Menu::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::destroy($id);
    }
}
