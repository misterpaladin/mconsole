<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MconsoleRoleRequest;
use Milax\Mconsole\Models\MconsoleRole;
use HasRedirects;
use HasPaginator;
use HasQueryTraits;

class RolesController extends Controller
{
    use HasQueryTraits, HasRedirects, HasPaginator;

    protected $model = 'Milax\Mconsole\Models\MconsoleRole';

    /**
     * Create new class instance
     */
    public function __construct()
    {
        $this->setRedirects(['/mconsole/roles', '/mconsole/roles', '/mconsole/roles']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setQuery(MconsoleRole::notRoot())->setPerPage(20)->run('mconsole::roles.list', function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::roles.table.name') => $item->name,
                trans('mconsole::roles.table.users') => $item->users->count(),
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
        return view('mconsole::roles.form', [
            'menu' => app('API')->menu->get(true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MconsoleRoleRequest $request)
    {
        MconsoleRole::create([
            'name' => $request->input('name'),
            'routes' => collect($request->input('routes'))->keys(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('mconsole::roles.form', [
            'item' => MconsoleRole::find($id),
            'menu' => app('API')->menu->get(true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MconsoleRoleRequest $request, $id)
    {
        MconsoleRole::find($id)->update([
            'name' => $request->input('name'),
            'routes' => collect($request->input('routes'))->keys(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (MconsoleRole::find($id)->users()->count() > 0) {
            return redirect()->back()->withErrors('Cannot role that in use.');
        } else {
            MconsoleRole::destroy($id);
        }
    }
}
