<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request and set the application locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        // Allow query override for deep links (?lang=ms), but don't persist unless route handles it
        $queryLocale = $request->query('lang') ?? $request->query('locale');
        if ($queryLocale && in_array($queryLocale, ['en', 'ms'], true)) {
            $locale = $queryLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}