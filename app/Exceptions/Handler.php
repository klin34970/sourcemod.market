<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
		if ($e instanceof ModelNotFoundException) 
		{
			$e = new NotFoundHttpException($e->getMessage(), $e);
		}

		//insert this snippet
		if ($this->isHttpException($e)) 
		{
			$statusCode = $e->getStatusCode();

			switch ($statusCode) 
			{
				case '401': return response()->view('laravel-authentication-acl::client.exceptions.401', array(), 401);
				case '404': return response()->view('laravel-authentication-acl::client.exceptions.404', array(), 404);
				case '500': return response()->view('laravel-authentication-acl::client.exceptions.500', array(), 500);
				default: return response()->view('laravel-authentication-acl::client.exceptions.500', array(), 500);
			}
		}

		return parent::render($request, $e);
	}
	
    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug')) 
		{
            return parent::convertExceptionToResponse($e);
        }

        return response()->view('laravel-authentication-acl::client.exceptions.500', array(), 500);
    }
}
