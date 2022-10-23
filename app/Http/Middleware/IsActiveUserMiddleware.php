<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsActiveUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status != 'active') {
            return response()->json(['message' => 'Your Account is suspended because your irregular activities, you can\'t do any actions on the platform, please contact with us to solve this problem'], 403);
        }
        return $next($request);
    }
}