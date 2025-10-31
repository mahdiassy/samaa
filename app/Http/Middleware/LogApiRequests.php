<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request and log API activity.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Process the request
        $response = $next($request);

        // Calculate execution time
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);

        // Log API request details
        Log::channel('api')->info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_id' => $request->user()?->id,
            'status' => $response->getStatusCode(),
            'execution_time_ms' => $executionTime,
            'user_agent' => $request->userAgent(),
        ]);

        // Log errors separately
        if ($response->getStatusCode() >= 400) {
            Log::channel('api')->error('API Error Response', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'status' => $response->getStatusCode(),
                'user_id' => $request->user()?->id,
                'request_body' => $request->except(['password', 'password_confirmation']),
            ]);
        }

        return $response;
    }
}
