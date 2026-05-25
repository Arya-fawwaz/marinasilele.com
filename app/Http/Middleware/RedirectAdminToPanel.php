<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminToPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Determine view mode using query, cookie, or session (multi-layer fallback)
        $viewMode = $request->query('view') ?: $request->cookie('admin_view_mode') ?: session('admin_view_mode');

        // 2. If 'view=user' query param is passed, set both session and cookie
        if ($request->query('view') === 'user') {
            session(['admin_view_mode' => 'user']);
            Cookie::queue('admin_view_mode', 'user', 60); // 60 minutes
            $viewMode = 'user';
        }

        // 3. Clear view mode if navigating to admin dashboard/routes (excluding preview-site)
        if (($request->is('admin') || $request->is('admin/*')) && !$request->is('admin/preview-site')) {
            session()->forget('admin_view_mode');
            Cookie::queue(Cookie::forget('admin_view_mode'));
            $viewMode = null;
        }

        if (auth()->check() && auth()->user()->isAdmin()) {
            if ($viewMode !== 'user') {
                if (!$request->is('admin') && !$request->is('admin/*') && !$request->is('logout')) {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}
