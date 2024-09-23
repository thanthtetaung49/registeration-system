<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->expectsJson()) {
            return $next($request); // Allow the request to pass through
        }

        if (Auth::check() && !Route::currentRouteName('calendar.index')) {
            if (Auth::user()->is_admin == 2 || Auth::user()->is_admin == 3) {
                return redirect()->route('scan.index');
            }
            return redirect()->route('calendar.index');
        }

        return $next($request);
    }
}
