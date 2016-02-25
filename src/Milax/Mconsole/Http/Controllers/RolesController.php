<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;

use Milax\Mconsole\Http\Requests\MconsoleRoleRequest;

use Milax\Mconsole\Models\MconsoleRole;
use Milax\Mconsole\Models\MconsoleMenu;

use Milax\Mconsole\Traits\Redirectable;
use Milax\Mconsole\Traits\Paginatable;

class RolesController extends Controller
{
	
	use Redirectable, Paginatable;
	
	protected $model = 'Milax\Mconsole\Models\MconsoleRole';
	protected $pageLength = 20;
	
	public function __construct()
	{
		$this->redirects(['/mconsole/permissions', '/mconsole/roles', '/mconsole/roles']);
	}
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return $this->paginate('mconsole::roles.list', function ($item) {
			return [
				'#' => $item->id,
				'Name' => $item->name,
				'Users' => $item->users->count(),
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
        return view('mconsole::roles.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MconsoleRoleRequest $request)
    {
		MconsoleRole::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('mconsole::roles.form', [
			'item' => MconsoleRole::find($id),
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MconsoleRoleRequest $request, $id)
    {
        MconsoleRole::find($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		if (MconsoleRole::find($id)->users()->count() > 0)
			return redirect()->back()->withErrors('Cannot role that in use.');
		else
			MconsoleRole::destroy($id);
    }
	
}