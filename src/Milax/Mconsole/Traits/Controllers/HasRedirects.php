<?php

namespace Milax\Mconsole\Traits\Controllers;

use Milax\Mconsole\Exceptions\ModelPropertyException;
use Milax\Mconsole\Exceptions\RedirectToPropertyException;
use Request;
use Session;
use URL;

/**
 * HasRedirects trait for Controllers
 */
trait HasRedirects
{
    protected $redirects = [];
    protected $disabled = false;
    
    /**
     * Set redirect url
     *
     * @param mixed $url
     * @return HasRedirects
     */
    protected function setRedirects($url)
    {
        $this->redirectTo = $url;
        return $this;
    }
    
    /**
     * Disable redirect for current request
     * 
     * @return HasRedirects
     */
    protected function noRedirect()
    {
        $this->disabled = true;
        return $this;
    }
    
    /**
     * Redirect to section url with message after create, update or delete request.
     * 
     * @access protected
     * @return Redirector
     */
    protected function handleRedirect()
    {
        // Repeat warning flash message
        Session::flash('warning', Session::get('warning'));
        
        // Show message depending on
        switch (Request::method()) {
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
    public function redirect()
    {
        // Check if $redirectTo is set
        if (empty($this->redirectTo)) {
            throw new RedirectToPropertyException(sprintf('You must set protected $redirectTo property in your controller %s.', __CLASS__));
        }
        
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
        
        $errors = !is_null(session('errors'));
        
        // If we need to redirect to edit saved object
        if (!$errors && app('API')->options->getByKey('editredirect')) {
            
            // Ensure that we have protected $model property in our controller
            if (strlen($this->model) == 0) {
                throw new ModelPropertyException('You must set protected $model property in order to use redirects to saved object.');
            }
            
            if (in_array(Request::method(), ['POST', 'PUT'])) {
                $model = $this->model;
                $id = $model::select('id')->orderBy('id', 'desc')->first()->id;
                $this->redirects = [
                    sprintf('%s/%s/edit', Request::url(), $id),
                    URL::previous(),
                    $this->redirectTo,
                ];
            }
        }
        
        // Check for session errors and request method
        if (Session::get('errors') === null && Request::method() != 'GET') {
            if (!$this->disabled) {
                $this->handleRedirect();
            }
        }
    }
}
