<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;

use Milax\Mconsole\Http\Requests\UserRequest;

use App\User;
use Milax\Mconsole\Models\MconsoleRole;

use Request;

use Filterable;
use Paginatable;
use Redirectable;

use Milax\Mconsole\Adaptors\TraitsAdaptor;

class UsersController extends Controller
{
	
	use Redirectable, Filterable, Paginatable;
	
	protected $redirectTo = '/mconsole/users';
	protected $model = 'App\User';
	protected $pageLength = 20;
	
	public function __construct()
	{
		$this->setText('Email', 'email', true)
			->setText('#', 'id', true)
			->setSelect('Role', 'role_id', MconsoleRole::all()->lists('name', 'id'), true);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->paginate('mconsole::users.list', function ($item) {
			return [
				'#' => $item->id,
				'Updated' => $item->updated_at,
				'Email' => $item->email,
				'Name' => $item->name,
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
		return view('mconsole::users.form');
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
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		return view('mconsole::users.form', [
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
	}
}
