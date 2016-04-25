<?php

namespace Milax\Mconsole\Exceptions\Handlers;

use Exception;
use Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class MconsoleExceptionHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }
    
    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();
        $trans = trans('mconsole::mconsole.errors');
        
        if (Request::segment(1) == 'mconsole' && isset($trans[$status])) {
            $view = 'mconsole::errors.error';
        } else {
            $view = sprintf('errors.%s', $status);
        }
        
        if (view()->exists($view)) {
            return response()->view($view, [
                'exception' => $e,
                'status' => $status,
                'text' => $trans,
            ], $status, $e->getHeaders());
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }
}
