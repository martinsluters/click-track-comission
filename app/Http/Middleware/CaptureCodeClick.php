<?php

namespace App\Http\Middleware;

use App\Events\Affiliate\CodeClickCaptured;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureCodeClick
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If no URL query parameter "aff" is present, continue.
        if (is_null($request->query('aff'))) {
            return $next($request);
        }

        event(new CodeClickCaptured($request));

        // If the route is the register route, continue.
        if($request->routeIs('register')) {
            return $next($request);
        }

        return redirect()->route('register');
    }
}
