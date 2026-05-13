<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    // Added: named rate limiters consumed by throttle:web, throttle:api-requests, throttle:login middleware
    public function boot(): void
    {
        // 20 req/min per authenticated user ID or IP for all web task routes
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });

        // 20 req/min per authenticated user ID or IP for all API task routes
        RateLimiter::for('api-requests', function (Request $request) {
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });

        // 5 req/min per IP; complements the per-username throttle already built into LoginRequest
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
