<?php

namespace Milax\Mconsole\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MconsoleUploadPresetRequest;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Contracts\Localizator;
use Milax\Mconsole\Contracts\ListRenderer;
use Milax\Mconsole\Contracts\FormRenderer;

class PresetsController extends Controller
{
    use \HasRedirects, \DoesNotHaveShow;

    protected $redirectTo = '/mconsole/presets';
    protected $model = 'Milax\Mconsole\Models\MconsoleUploadPreset';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $list, FormRenderer $form)
    {
        $this->list = $list;
        $this->form = $form;
        $this->form->addScripts([
            '/massets/js/presets.js',
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->list->setQuery(MconsoleUploadPreset::query())->setAddAction('presets/create')->render(function ($item) {
            return [
                trans('mconsole::presets.table.id') => $item->id,
                trans('mconsole::presets.table.name') => $item->name,
                trans('mconsole::presets.table.type') => trans(sprintf('mconsole::presets.types.%s', $item->type)),
                trans('mconsole::presets.table.operations') => count($item->operations),
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
        return $this->form->render('mconsole::presets.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MconsoleUploadPresetRequest $request)
    {
        $data = $request->all();
        
        $data['extensions'] = explode(',', $data['extensions']);
        foreach ($data['extensions'] as &$extension) {
            $extension = trim($extension);
        }
        
        $data['operations'] = json_decode($data['operations'], true);
        
        $preset = MconsoleUploadPreset::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $preset = MconsoleUploadPreset::findOrFail($id);
        $preset->extensions = implode(', ', $preset->extensions);
        $preset->operations = json_encode($preset->operations);
        return $this->form->render('mconsole::presets.form', [
            'item' => $preset,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(MconsoleUploadPresetRequest $request, $id)
    {
        $data = $request->all();
        
        $data['extensions'] = explode(',', $data['extensions']);
        foreach ($data['extensions'] as &$extension) {
            $extension = trim($extension);
        }
        
        $data['operations'] = json_decode($data['operations'], true);
        
        MconsoleUploadPreset::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preset = MconsoleUploadPreset::findOrFail($id);
        if ($preset->system) {
            return redirect()->back()->withErrors(trans('mconsole::mconsole.errors.system'));
        }

        MconsoleUploadPreset::destroy($id);
    }
}
