<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     * 46.4.113.124
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->ip(), ["46.4.113.124", "127.0.0.1"]))
            return $next($request);
        else
            return response()->json(['error'=>'access denied']);
    }
}
