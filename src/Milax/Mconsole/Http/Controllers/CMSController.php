<?php

namespace Milax\Mconsole\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Milax\Mconsole\Exceptions\NoUrlPropertyException;

class CMSController extends Controller
{
	
	protected $redirectTo;
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
	
	/**
	 * Redirect to section url with message after create, update or delete request.
	 * 
	 * @access protected
	 * @return Redirector
	 */
	protected function redirect()
	{
		// Check for url property to use this method
		if (strlen($this->redirectTo) == 0)
			throw new NoUrlPropertyException('You must set protected $redirectTo controller property to use $this->redirect method.');
		
		// Show message depending on
		switch (\Request::method())
		{
			case 'POST':
				return redirect($this->redirectTo)->with('status', trans('mconsole::mconsole.status.created'));
			case 'PUT':
			case 'UPDATE':
				return redirect($this->redirectTo)->with('status', trans('mconsole::mconsole.status.updated'));
			case 'DELETE':
				return redirect($this->redirectTo)->with('status', trans('mconsole::mconsole.status.deleted'));
		}
	}

}
