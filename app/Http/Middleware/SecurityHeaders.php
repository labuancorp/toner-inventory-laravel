<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and add security-related HTTP headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Content Security Policy (relaxed inline allowances due to Vite / inline handlers)
        $csp = "default-src 'self'; "
            . "img-src 'self' data: https:; "
            . "style-src 'self' 'unsafe-inline'; "
            . "script-src 'self' 'unsafe-inline' 'unsafe-eval'; "
            . "font-src 'self' data: https:; "
            . "connect-src 'self' ws: wss:; "
            . "frame-ancestors 'none'";

        $headers = [
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'no-referrer',
            'Permissions-Policy' => "geolocation=(), microphone=(), camera=()",
            'Content-Security-Policy' => $csp,
            'Cross-Origin-Opener-Policy' => 'same-origin',
            'Cross-Origin-Resource-Policy' => 'same-origin',
        ];

        foreach ($headers as $key => $value) {
            // Preserve existing values if already set
            if (! $response->headers->has($key)) {
                $response->headers->set($key, $value);
            }
        }

        return $response;
    }
}