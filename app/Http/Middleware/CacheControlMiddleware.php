<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set Cache-Control header for 5 minutes (300 seconds) private cache and 10 minutes (600 seconds) public cache.
        $response->header('Cache-Control', 'public, max-age=300, s-maxage=600');

        return $response;
    }
}
