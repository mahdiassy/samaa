<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // API rate limiting
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Login attempts - 5 per minute per IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'title' => __('site.Error'),
                        'msg' => __('site.Too many login attempts. Please try again in 1 minute.'),
                    ]);
                });
        });

        // Registration attempts - 3 per minute per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'title' => __('site.Error'),
                        'msg' => __('site.Too many registration attempts. Please try again in 1 minute.'),
                    ]);
                });
        });

        // Contact form - 5 per hour per IP
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'title' => __('site.Error'),
                        'msg' => __('site.Too many submissions. Please try again later.'),
                    ]);
                });
        });

        // Password reset - 3 per hour per IP
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perHour(3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return redirect()->back()->with('status', [
                        'type' => 'error',
                        'title' => __('site.Error'),
                        'msg' => __('site.Too many password reset attempts. Please try again later.'),
                    ]);
                });
        });

        // ========================================
        // API Rate Limiters
        // ========================================

        // Auth endpoints (login, register) - 5 per minute per IP
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // General API - 60 requests per minute per user/IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Booking endpoints - 10 per minute (prevent spam)
        RateLimiter::for('booking', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        // File uploads - 5 per minute
        RateLimiter::for('uploads', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }
}
