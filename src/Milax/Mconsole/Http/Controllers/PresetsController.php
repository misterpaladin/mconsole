<?php

namespace Milax\Mconsole\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\MconsoleUploadPresetRequest;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Contracts\Localizator;
use Paginatable;
use Redirectable;
use HasQueryTraits;

class PresetsController extends Controller
{
    use HasQueryTraits, Redirectable, Paginatable;

    protected $redirectTo = '/mconsole/presets';
    protected $model = 'Milax\Mconsole\Models\MconsoleUploadPreset';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setPerPage(20)->run('mconsole::presets.list', function ($item) {
            return [
                trans('mconsole::presets.table.id') => $item->id,
                trans('mconsole::presets.table.name') => $item->name,
                trans('mconsole::presets.table.operations') => count(json_decode($item->operations)),
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
        MconsoleUploadPreset::find($id)->update($request->all());
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
