<?php

namespace Milax\Mconsole\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milax\Mconsole\Models\MconsoleRole;
use Milax\Mconsole\Models\MconsoleMenu;
use Milax\Mconsole\Traits\Redirectable;
use DB;

class PermissionsController extends Controller
{
    use Redirectable;

    protected $redirectTo = '/mconsole/permissions';
    protected $permissionsTable = 'mconsole_roles_menus';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mconsole::permissions.form', [
            'roles' => MconsoleRole::all(),
            'menu' => MconsoleMenu::with('roles')->get(),
        ]);
    }

    /**
     * Save roles permissions.
     * 
     * @return [type] [description]
     */
    public function store(Request $request)
    {
        DB::table($this->permissionsTable)->truncate();
        foreach ($request->input('roles') as $menu => $roles) {
            foreach ($roles as $role => $vaue) {
                DB::table($this->permissionsTable)->insert([
                    'menu_id' => $menu,
                    'role_id' => $role,
                ]);
            }
        }
    }
}
