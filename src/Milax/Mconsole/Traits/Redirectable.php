<?php

namespace Milax\Mconsole\Traits;

use Milax\Mconsole\Exceptions\NoRedirectToPropertyException;

use Request;
use Session;

/**
 * Redirectable trait for Controllers
 */
trait Redirectable
{
    
    /**
     * Check for "redirectTo" property
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
		// Session::forget('status');
        if (empty($this->redirectTo))
            throw new NoRedirectToPropertyException('You must set protected $redirectTo property in your controller.');
    }
    
	/**
	 * Redirect to section url with message after create, update or delete request.
	 * 
	 * @access protected
	 * @return Redirector
	 */
	protected function redirect()
	{
        // Show message depending on
		switch (Request::method())
		{
			case 'POST':
				Session::flash('status', trans('mconsole::mconsole.status.created'));
			case 'PUT':
			case 'UPDATE':
				Session::flash('status', trans('mconsole::mconsole.status.updated'));
			case 'DELETE':
				Session::flash('status', trans('mconsole::mconsole.status.deleted'));
			
			return abort(302, null, ['Location' => $this->redirectTo]);
		}
        
	}
    
    /**
     * Check if session doesn't have errors and request method is not GET
     */
    public function __destruct()
    {
        if (Session::get('errors') === null && Request::method() != 'GET')
            $this->redirect();
    }
    
}