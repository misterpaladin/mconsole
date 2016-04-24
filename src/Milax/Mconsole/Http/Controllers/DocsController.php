<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DocsParser;
use Milax\Mconsole\Models\MconsoleDocset;

class DocsController extends Controller
{
    protected $docsets = [];
    
    /**
     * Create new instance
     */
    public function __construct(DocsParser $parser)
    {
        $this->parser = $parser;
    }
    
    /**
     * Display mconsole index page.
     * 
     * @return Response
     */
    public function index()
    {
        $mconsole = new MconsoleDocset($this->parser->scanDocs(sprintf('%s/../../../../docs', __DIR__)), 'Mconsole', trans('mconsole::docs.mconsole.description'));
        
        array_push($this->docsets, $mconsole);
        
        foreach (app('API')->modules->get('installed') as $module) {
            if ($module->docs) {
                $moduleDocs = new MconsoleDocset($this->parser->scanDocs($module->docs), str_replace(' ', '-', $module->name), trans($module->description));
                array_push($this->docsets, $moduleDocs);
            }
        }
        
        return view('mconsole::pages.docs', [
            'docsets' => $this->docsets,
            // 'contents' => $this->parser->parseMarkdown($index),
        ]);
    }
}
