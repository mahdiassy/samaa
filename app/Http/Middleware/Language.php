<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Session()->has('app_locale') && array_key_exists(Session()->get('app_locale'), config('languages')))
            App::setLocale(Session()->get('app_locale'));
        else
            App::setLocale(config('app.fallback_locale'));
        return $next($request);
    }
}
