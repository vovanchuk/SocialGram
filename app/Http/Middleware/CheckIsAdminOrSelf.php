<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminOrSelf
{
    public function handle($request, Closure $next)
    {
        $requestedUsername = $request->route()->parameter('username');
        if (
            Auth::user()->role === 2 ||
            Auth::user()->username == $requestedUsername
        ) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
