<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCacheHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Set cache headers for static assets
        if ($request->is('css/*', 'js/*', 'img/*', 'fonts/*')) {
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
        } 
        // Set cache headers for HTML pages (1 hour)
        elseif ($response->headers->get('content-type') && strpos($response->headers->get('content-type'), 'text/html') !== false) {
            $response->header('Cache-Control', 'public, max-age=3600, must-revalidate');
        }

        return $response;
    }
}
