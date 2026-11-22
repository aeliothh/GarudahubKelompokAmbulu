<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // Membuat nonce unik untuk setiap request
        $nonce = base64_encode(random_bytes(16));

        // Membagikan nonce ke seluruh Blade view
        View::share('cspNonce', $nonce);

        $response = $next($request);

        // Content Security Policy
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self'; " .
            "style-src 'self' 'nonce-{$nonce}'; " .
            "style-src-attr 'none'; " .
            "img-src 'self' data:; " .
            "font-src 'self' data:; " .
            "connect-src 'self'; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self'; " .
            "frame-ancestors 'none'"
        );

        // Perlindungan Clickjacking
        $response->headers->set(
            'X-Frame-Options',
            'DENY'
        );

        // Mencegah MIME Sniffing
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        // Mengatur Referrer Policy
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        return $response;
    }
}
