<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasRole('super-admin')) {
            return response()->json(['message' => 'You are not authorized to access this content'], 403);
        }
        return $next($request);
    }
}
