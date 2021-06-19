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
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            $sessionMiddleware = resolve(StartSession::class);
            $decrypter = resolve(EncryptCookies::class);
            $decrypter->handle(request(), fn() => $sessionMiddleware->handle(request(), fn() => response('')));

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
