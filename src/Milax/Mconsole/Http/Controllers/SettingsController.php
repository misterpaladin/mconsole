<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleOption;
use Milax\Mconsole\Http\Requests\SettingsRequest;
use Milax\Mconsole\Contracts\Repositories\SettingsRepository;

class SettingsController extends Controller
{
    use \UseLayout;

    protected $repository;
    
    public function __construct(SettingsRepository $repository)
    {
        $this->setCaption(trans('mconsole::settings.menu.name'));
        $this->repository = $repository;
    }
    
    /**
     * Show settings form
     * 
     * @return Response
     */
    public function index()
    {
        return view('mconsole::settings.form', [
            'options' => $this->repository->get(),
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
        
        $this->repository->get()->each(function ($option) use (&$request, &$toSave) {
            $option = $option->toArray();
            if ($option['type'] == 'checkbox') {
                $option['value'] = $request->input($option['key']) ? 1 : 0;
            } else {
                $option['value'] = $request->input($option['key']);
            }
            
            if ($option['rules'] && count($option['rules']) > 0) {
                $option['rules'] = json_encode($option['rules']);
            }
            
            if ($option['options'] && count($option['options']) > 0) {
                $option['options'] = json_encode($option['options']);
            }
            
            unset($option['created_at']);
            $option['updated_at'] = today();
            
            array_push($toSave, $option);
        });
        
        $model = $this->repository->model;
        
        $model::truncate();
        $model::insert($toSave);
        $model::dropCache();
        
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
        return redirect()->back()->with('status', trans('mconsole::settings.additional.cache.cleared'));
    }
    
    /**
     * Reload modules language files
     * 
     * @return Response
     */
    public function reloadTranslations()
    {
        app('API')->translations->load();
        return redirect()->back()->with('status', trans('mconsole::settings.additional.translations.reloaded'));
    }
}
