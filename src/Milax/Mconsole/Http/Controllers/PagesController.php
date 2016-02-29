<?php

namespace Milax\Mconsole\Http\Controllers;

use Milax;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Http\Requests\PageRequest;
use Milax\Mconsole\Models\Page;
use Paginatable;
use Redirectable;
use HasQueryTraits;

class PagesController extends Controller
{
    use HasQueryTraits, Redirectable, Paginatable;

    protected $redirectTo = '/mconsole/pages';
    protected $model = 'Milax\Mconsole\Models\Page';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->setPerPage(20)->run('mconsole::pages.list', function ($item) {
            return [
                '#' => $item->id,
                'Updated' => $item->updated_at->format('m.d.Y'),
                'Slug' => $item->slug,
                'Heading' => $item->heading,
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
        return view('mconsole::pages.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $page = Page::create($request->all());
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = Milax\Mconsole\Models\ContentLink::find((int) $link['id'])) {
                        $dbLink->update($link);
                    } else {
                        $page->links()->create($link);
                    }
                } else {
                    $page->links()->create($link);
                }
            }
        }
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
        $page = Page::with('links')->find($id);
        $page->links = $page->links->sortBy('order')->toJson();
        return view('mconsole::pages.form', [
            'item' => $page,
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
    public function update(PageRequest $request, $id)
    {
        $page = Page::find($id);
        
        if (strlen($request->input('links')) > 0) {
            $links = collect(json_decode($request->input('links'), true));
            $page->links()->whereNotIn('id', $links->lists('id'))->delete();
            
            foreach ($links as $link) {
                if (strlen($link['id']) > 0) {
                    if ($dbLink = Milax\Mconsole\Models\ContentLink::find((int) $link['id'])) {
                        $dbLink->update($link);
                    } else {
                        $page->links()->create($link);
                    }
                } else {
                    $page->links()->create($link);
                }
            }
        }
        
        $page->update($request->all());
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
        $page = Page::find($id);
        if ($page->system) {
            return redirect()->back()->withErrors('System!!!');
        }

        Page::destroy($id);
    }
}
