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
use HasQueryTraits;

class UsersController extends Controller
{
    use HasQueryTraits, Redirectable, Filterable, Paginatable;
    
    protected $redirectTo = '/mconsole/users';
    protected $model = 'App\User';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setText(trans('mconsole::users.filter.email'), 'email', true)
            ->setText(trans('mconsole::users.filter.id'), 'id', true)
            ->setSelect(trans('mconsole::users.filter.role'), 'role_id', MconsoleRole::all()->lists('name', 'id'), true);
        
        return $this->setPerPage(2)->run('mconsole::users.list', function ($item) {
            return [
                trans('mconsole::users.table.id') => $item->id,
                trans('mconsole::users.table.updated') => $item->updated_at->format('Y'),
                trans('mconsole::users.table.email') => $item->email,
                trans('mconsole::users.table.name') => $item->name,
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
