<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;

use Milax\Mconsole\Http\Requests\UserRequest;

use App\User;

use Request;

class UsersController extends Controller
{
	
	protected $redirectTo = '/mconsole/users';
	
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
		return $this->view('mconsole.users.form');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		User::create([
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password')),
		]);
		return $this->redirect();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return $this->view('mconsole.users.form', [
			'item' => User::find($id),
		]);
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
		User::find($id)->update($request->all());
		return $this->redirect();
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
		return $this->redirect();
	}
}
