<?php

namespace Milax\Mconsole\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MconsoleUploadPresetRequest;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Contracts\Localizator;
use ListRenderer;

class PresetsController extends Controller
{
    use \HasRedirects;

    protected $redirectTo = '/mconsole/presets';
    protected $model = 'Milax\Mconsole\Models\MconsoleUploadPreset';
    
    /**
     * Create new class instance
     */
    public function __construct(ListRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->renderer->setQuery(MconsoleUploadPreset::query())->setPerPage(20)->setAddAction('presets/create')->render(function ($item) {
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
        return view('mconsole::presets.form');
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
        $preset = MconsoleUploadPreset::find($id);
        $preset->extensions = implode(', ', $preset->extensions);
        $preset->operations = json_encode($preset->operations);
        return view('mconsole::presets.form', [
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
        
        MconsoleUploadPreset::find($id)->update($data);
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
        $preset = MconsoleUploadPreset::find($id);
        if ($preset->system) {
            return redirect()->back()->withErrors(trans('mconsole::mconsole.errors.system'));
        }

        MconsoleUploadPreset::destroy($id);
    }
}
