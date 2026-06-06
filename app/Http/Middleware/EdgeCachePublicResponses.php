<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EdgeCachePublicResponses
{
    /**
     * Handle an incoming request and apply Edge Caching for guests.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya cache request GET untuk guest/pengunjung yang belum login
        if ($request->isMethod('GET') && !auth()->check()) {
            // Cache di Vercel CDN selama 60 detik, izinkan stale-while-revalidate selama 10 menit
            $response->headers->set('Cache-Control', 'public, max-age=60, s-maxage=60, stale-while-revalidate=600');
        } else {
            // Pastikan tidak ada caching untuk user yang sudah login demi keamanan data
            $response->headers->set('Cache-Control', 'no-cache, private, no-store, must-revalidate');
        }

        return $response;
    }
}
