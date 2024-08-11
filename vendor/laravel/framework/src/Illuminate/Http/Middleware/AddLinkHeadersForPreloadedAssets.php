<?php

namespace Illuminate\Http\Middleware;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;

class AddLinkHeadersForPreloadedAssets
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        // if (Auth::check() && !Route::currentRouteName('calendar.index')) {
        //     if (Auth::user()->is_admin != 2) {
        //         return redirect()->route('calendar.index');
        //     }

        //     return redirect()->route('security.index');
        // }

        return tap($next($request), function ($response) {
            if (Vite::preloadedAssets() !== []) {
               $test =  $response->header('Link', Collection::make(Vite::preloadedAssets())
                    ->map(fn ($attributes, $url) => "<{$url}>; ".implode('; ', $attributes))
                    ->join(', '));
            }
        });
    }
}
