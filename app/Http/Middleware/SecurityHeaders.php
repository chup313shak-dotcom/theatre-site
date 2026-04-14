<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Защита от Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Дополнительная защита: предотвращение MIME-sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Защита от XSS (для старых браузеров)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}
