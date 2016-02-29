<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milax\Mconsole\Models\MconsoleUploadPreset;

class TestController extends Controller
{
    use \Milax\Mconsole\Traits\Uploadable;

    public function index()
    {
        return view('mconsole::test');
        // return view('mconsole::test', [
            // 'presets' => MconsoleUploadPreset::get()->lists('name', 'id'),
        // ]);
    }

    public function store(Request $request)
    {
        dump('TestController');
// 		\Milax\Mconsole\Models\Page::create(['slug' => str_random(5)]);
    }
}
