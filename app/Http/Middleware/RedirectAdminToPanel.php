<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminToPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            if (!$request->is('admin') && !$request->is('admin/*') && !$request->is('logout')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
