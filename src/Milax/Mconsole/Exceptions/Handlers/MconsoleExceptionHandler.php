<?php

namespace Milax\Mconsole\Exceptions\Handlers;

Use Throwable;
use Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;

class MconsoleExceptionHandler extends ExceptionHandler implements ExceptionHandlerContract
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
     * @param  \Throwable  $e
     * @return void
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    public function shouldReport(Throwable $e)
    {
        parent::shouldReport($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpException) {
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

        return parent::render($request, $e);
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Throwable  $e
     * @return void
     */
    public function renderForConsole($output, Throwable $e)
    {
        parent::renderForConsole($output, $e);
    }
    
    
}
