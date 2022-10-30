<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        app()->setLocale($request->get('locale') ?? 'en');
        return $next($request);
    }
}
