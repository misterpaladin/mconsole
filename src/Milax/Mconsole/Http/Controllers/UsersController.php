<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\UserRequest;
use App\User;
use Milax\Mconsole\Models\MconsoleRole;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;

class UsersController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow;
    
    protected $redirectTo = '/mconsole/users';
    protected $model = 'App\User';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form)
    {
        $this->list = $list;
        $this->form = $form;
        $this->roles = MconsoleRole::notRoot()->get()->lists('name', 'id');
        $this->roles->prepend(trans('mconsole::users.types.generic'), 0);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->list->setText(trans('mconsole::users.filter.email'), 'email', true)
            ->setText(trans('mconsole::users.filter.id'), 'id', true)
            ->setSelect(trans('mconsole::users.filter.role'), 'role_id', $this->roles, true);
        
        return $this->list->setQuery(User::query())->setAddAction('users/create')->render(function ($item) {
            return [
                '#' => $item->id,
                trans('mconsole::users.table.updated') => $item->updated_at->format('m.d.Y'),
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
        return $this->form->render('mconsole::users.form', [
            'roles' => $this->roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->role_id = $request->input('role_id');
        $user->email = $request->input('email');
        $user->lang = $request->input('lang');
        $user->password = bcrypt($request->input('password'));
        $user->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->form->render('mconsole::users.form', [
            'item' => User::findOrFail($id),
            'roles' => $this->roles,
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
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->lang = $request->input('lang');
        
        if ($request->input('role_id')) {
            $user->role_id = $request->input('role_id');
        }
        
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
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
