<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() === null || Auth::user()->cant('admin_panel')) {
            abort(403);
        }
        return $next($request);
    }
}
