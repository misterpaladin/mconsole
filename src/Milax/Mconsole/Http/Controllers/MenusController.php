<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MenuRequest;
use Milax\Mconsole\Models\Menu;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;

class MenusController extends Controller
{
    use \HasRedirects;
    
    protected $model = 'Milax\Mconsole\Models\Menu';
    protected $redirectTo = '/mconsole/menus';
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form)
    {
        $this->list = $list;
        $this->form = $form;
        $this->form->addStyles([
            '/massets/global/plugins/jquery-nestable/jquery.nestable.css',
            '/massets/css/menu-editor.css',
        ]);
        $this->form->addScripts([
            '/massets/global/plugins/jquery-nestable/jquery.nestable.js',
            '/massets/js/menu-editor.js',
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->list->setQuery(Menu::query())->setPerPage(20)->setAddAction('menus/create')->render(function ($item) {
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
        return $this->form->render('mconsole::menu.form');
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
        return $this->form->render('mconsole::menu.form', [
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
