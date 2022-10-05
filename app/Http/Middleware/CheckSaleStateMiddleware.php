<?php

namespace App\Http\Middleware;

use App\Models\Nft;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckSaleStateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Nft::where('sale_end_at', '<=', Carbon::now())->update(['is_for_sale' => false]);
        return $next($request);
    }
}
