<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Variable;

class VariablesController extends Controller
{
    /**
     * Show variables form
     * 
     * @return Response
     */
    public function index()
    {
        return view('mconsole::variables.form', [
            'variables' => Variable::all(),
        ]);
    }
    
    /**
     * Save variables values
     * 
     * @param  Request $request
     * @return Redirect
     */
    public function save(Request $request)
    {
        Variable::truncate();
        
        $data = collect($request->input('variables'))->reject(function ($variable) {
            return strlen($variable['key']) == 0;
        });
        if ($data->count() > 0) {
            Variable::insert($data->toArray());
        }        
        
        return redirect()->back()->with('status', trans('mconsole::variables.saved'));
    }
}
