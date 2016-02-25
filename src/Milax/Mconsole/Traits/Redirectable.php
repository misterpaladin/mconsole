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
	
	protected $redirects = [];
	
	/**
	 * Set redirect url
	 *
	 * @param mixed $url
	 * @return [type] [description]
	 */
	public function redirects($url)
	{
		$this->redirectTo = $url;
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
				return abort(302, null, ['Location' => $this->redirects[0]]);
			case 'PUT':
			case 'UPDATE':
				Session::flash('status', trans('mconsole::mconsole.status.updated'));
				return abort(302, null, ['Location' => $this->redirects[1]]);
			case 'DELETE':
				Session::flash('status', trans('mconsole::mconsole.status.deleted'));
				return abort(302, null, ['Location' => $this->redirects[2]]);
		}
        
	}
    
    /**
     * Check if session doesn't have errors and request method is not GET
     */
    public function __destruct()
    {
		// Check if $redirectTo is set
		if (empty($this->redirectTo))
            throw new RedirectToPropertyException('You must set protected $redirectTo property in your controller.');
		
		// Check if $redirectTo is array
		if (is_array($this->redirectTo)) {
			if (count($this->redirectTo) < 3) {
				throw new RedirectToPropertyException('$redirectTo property must be string or array with 3 elements (create, update, delete urls).');
			} else {
				$this->redirects = $this->redirectTo;
			}
		} else {
			$this->redirects = [
				$this->redirectTo,
				$this->redirectTo,
				$this->redirectTo,
			];
		}
		
		// Check for session errors and request method
        if (Session::get('errors') === null && Request::method() != 'GET')
            $this->redirect();
    }
    
}