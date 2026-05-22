<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrManagerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isManager())) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
