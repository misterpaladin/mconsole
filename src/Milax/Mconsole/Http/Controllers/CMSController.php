<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CMSController extends Controller
{
	
	protected $uri;
	protected $model;
	
	/**
	 * Override 'view()' helper, check for existed views..
	 *
	 * @access protected
	 * @param string $view
	 * @param array $args (default: [])
	 * @return View
	 */
	protected function view($view, $args = [])
	{
		if (view()->exists('app') || starts_with($view, 'mconsole::'))
			return view($view, $args);
		else
			return view('mconsole::' . $view, $args);
	}

}
