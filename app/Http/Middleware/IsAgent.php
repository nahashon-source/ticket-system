<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class IsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        // no 'use Auth;' here
        if (Auth::check() && Auth::user()->role === 'agent')
 {
            return $next($request);
        }

        abort(403, 'Unauthorized access — agents only.');
    }
}
