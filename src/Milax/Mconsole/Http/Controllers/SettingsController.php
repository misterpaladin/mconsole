<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Http\Requests\SettingsRequest;

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
    public function save(SettingsRequest $request)
    {
        $toSave = [];
        MconsoleOption::all()->each(function ($option) use (&$request, &$toSave) {
            $option = $option->toArray();
            if ($option['type'] == 'checkbox') {
                if ($request->input($option['key'])) {
                    $option['value'] = 1;
                } else {
                    $option['value'] = 0;
                }
            } else {
                $option['value'] = $request->input($option['key']);
            }
            
            if ($option['rules'] && count($option['rules']) > 0) {
                $option['rules'] = json_encode($option['rules']);
            }
            
            if ($option['options'] && count($option['options']) > 0) {
                $option['options'] = json_encode($option['options']);
            }
            
            $option['updated_at'] = \Carbon\Carbon::now();
            
            array_push($toSave, $option);
        });
        
        MconsoleOption::truncate();
        MconsoleOption::insert($toSave);
        
        return redirect()->back()->with('status', trans('mconsole::settings.saved'));
    }
    
    /**
     * Clear application caches
     * 
     * @return Redirect
     */
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return redirect()->back()->with('status', trans('mconsole::settings.additional.cachecleared'));
    }
}
