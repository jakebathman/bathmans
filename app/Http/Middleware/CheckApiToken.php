<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiToken
{
    public function handle($request, Closure $next)
    {
        if ($request->get('token') != config('auth.api_token')) {
            return abort(401);
        }

        return $next($request);
    }
}
