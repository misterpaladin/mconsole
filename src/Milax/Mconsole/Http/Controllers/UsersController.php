<?php

namespace Milax\Mconsole\Http\Controllers;

use Milax\Mconsole\Http\Controllers\CMSController;

use Milax\Mconsole\Http\Requests\UserRequest;

use App\User;

class UsersController extends CMSController
{
	
	use \Milax\Mconsole\Traits\Filterable;
	
	protected $query;
	protected $model = 'App\User';
	protected $filters = [
		['text' => 'name'],
	];
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$items = User::paginate(20);
		return $this->view('mconsole.users.list', [
			'paging' => $items,
			'items' => $items->transform(function ($item) {
				return [
					'#' => $item->id,
					'Updated' => $item->updated_at->format('m.d.Y'),
					'Email' => $item->email,
					'Name' => $item->name,
				];
			}),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return $this->view('mconsole.users.add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		User::destroy($id);
		return redirect()->back()->with('success', 'User deleted.');
	}
}
