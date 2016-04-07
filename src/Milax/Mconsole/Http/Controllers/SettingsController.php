<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleOption;

class SettingsController extends Controller
{
    /**
     * Show settings form
     * 
     * @return Response
     */
    public function index()
    {
        return view('mconsole::settings.form', [
            'options' => MconsoleOption::all(),
        ]);
    }
    
    /**
     * Save settings values
     * 
     * @param  Request $request
     * @return Redirect
     */
    public function save(Request $request)
    {
        MconsoleOption::all()->each(function ($option) use ($request) {
            if ($option->type == 'checkbox') {
                if ($request->input($option->key)) {
                    $option->value = 1;
                } else {
                    $option->value = 0;
                }
            } else {
                $option->value = $request->input($option->key);
            }
            $option->save();
        });
        
        return redirect()->back()->with('status', trans('mconsole::settings.saved'));
    }
}
