<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'You are not authorized to access this content'], 403);
        }
        return $next($request);
    }
}
