<?php

namespace App\Http\Middleware;

use Closure;

class AjaxCheck
{
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }

        if (!$request->ajax()) {
            return response('Forbidden.', 403);
        }

        return $next($request);
    }
}
