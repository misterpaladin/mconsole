<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\Variable;
use Milax\Mconsole\Contracts\Repositories\VariablesRepository;

class VariablesController extends Controller
{
    use \UseLayout;

    protected $repository;
    
    public function __construct(VariablesRepository $repository)
    {
        $this->setCaption(trans('mconsole::variables.menu.name'));
        $this->repository = $repository;
    }
    
    /**
     * Show variables form
     * 
     * @return Response
     */
    public function index()
    {
        return view('mconsole::variables.form', [
            'variables' => $this->repository->query()->orderBy('key', 'asc')->get(),
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
        $model = $this->repository->model;
        
        $model::truncate();
        
        $data = collect($request->input('variables'))->reject(function ($variable) {
            return strlen($variable['key']) == 0;
        });
        if ($data->count() > 0) {
            $this->repository->insert($data->toArray());
        }
        
        $model::dropCache();
        
        return redirect()->back()->with('status', trans('mconsole::variables.saved'));
    }
}
