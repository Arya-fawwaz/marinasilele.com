<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dynamically optimize configurations for Vercel Serverless environment
        if (env('VERCEL') === '1') {
            config([
                'view.compiled' => '/tmp',
                'session.driver' => 'cookie',
                'cache.default' => 'array',
                'logging.default' => 'stderr',
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Vercel is always HTTPS)
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        // Vite: use aggressive prefetch to preload all assets
        Vite::prefetch(concurrency: 3);

        // Prevent lazy loading in non-production (catch N+1 issues)
        Model::preventLazyLoading(! app()->isProduction());
    }
}
