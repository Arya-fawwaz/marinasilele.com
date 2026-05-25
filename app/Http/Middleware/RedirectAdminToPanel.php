<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminToPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('view') === 'user') {
            session(['admin_view_mode' => 'user']);
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            session()->forget('admin_view_mode');
        }

        if (auth()->check() && auth()->user()->isAdmin()) {
            if (session('admin_view_mode') !== 'user') {
                if (!$request->is('admin') && !$request->is('admin/*') && !$request->is('logout')) {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}
