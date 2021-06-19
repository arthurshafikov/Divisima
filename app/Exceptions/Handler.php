<?php

namespace App\Exceptions;

use Error;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            $sessionMiddleware = resolve(StartSession::class);
            $decrypter = resolve(EncryptCookies::class);
            $decrypter->handle(request(), fn() => $sessionMiddleware->handle(request(), fn() => response('')));
            // for 404 auth user

            return response()->view('errors.default', [
                'errorCode' => 404,
                'errorMessage' => 'Page not found',
            ], 404);
        }


        if ($exception instanceof HttpException) {
            if ($exception->getStatusCode() == 403) {
                return response()->view('errors.default', [
                    'errorCode' => 403,
                    'errorMessage' => 'Access Denied',
                ], 403);
            } elseif ($exception->getStatusCode() == 401) {
                return response()->view('errors.default', [
                    'errorCode' => 401,
                    'errorMessage' => 'Unathorized',
                ], 401);
            } elseif ($exception->getStatusCode() == 500) {
                return response()->view('errors.default', [
                    'errorCode' => 500,
                    'errorMessage' => 'Internal server error',
                ], 500);
            }
        }

        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.default', [
                'errorCode' => 401,
                'errorMessage' => 'Unathorized',
            ], 401);
        }

        if ($exception instanceof Error) {
            return response()->view('errors.default', [
                'errorCode' => 500,
                'errorMessage' => 'Internal server error',
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
