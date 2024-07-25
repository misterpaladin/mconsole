<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milax\Mconsole\Http\Requests\UserRequest;
use App\Models\User;
use Milax\Mconsole\Models\MconsoleRole;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;
use Milax\Mconsole\Contracts\Repositories\UsersRepository;
use Milax\Mconsole\Contracts\Repositories\RolesRepository;

class UsersController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow, \UseLayout;
    
    protected $model = 'App\Models\User';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form, UsersRepository $repository, RolesRepository $roles)
    {
        $this->setCaption(trans('mconsole::users.menu.name'));
        $this->list = $list;
        $this->form = $form;
        $this->repository = $repository;
        $this->roles = $roles;
        $this->redirectTo = mconsole_url('users');
        $this->roles = $this->roles->query()->notRoot()->get()->pluck('name', 'id');
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
        
        return $this->list->setQuery($this->repository->index())->setAddAction('users/create')->render(function ($item) {
            return [
                trans('mconsole::tables.id') => $item->id,
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
        $user = new $this->repository->model;
        $user->name = $request->input('name');
        $user->role_id = $request->input('role_id');
        $user->email = $request->input('email');
        $user->lang = $request->input('lang');
        $user->password = bcrypt($request->input('password'));
        $user->update_own = $request->input('update_own');
        $user->save();
        $this->redirect();
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
            'item' => $this->repository->find($id),
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
        $user = $this->repository->find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->lang = $request->input('lang');
        $user->update_own = $request->input('update_own');
        
        if ($request->input('role_id')) {
            $user->role_id = $request->input('role_id');
        }
        
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        
        $user->save();
        $this->redirect();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);
        $this->redirect();
    }
    
    /**
     * Update user menu order
     * 
     * @param  int $id    [User id]
     * @return void
     */
    public function updateMenuOrder(Request $request, $id)
    {
        $this->repository->update($id, [
            'menus' => json_decode($request->input('menus'), true),
        ]);
    }
}
