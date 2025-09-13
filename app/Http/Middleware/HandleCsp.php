<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleCsp
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Supprimer les en-têtes CSP
        $response->headers->remove('Content-Security-Policy');
        $response->headers->remove('X-Content-Security-Policy');
        $response->headers->remove('X-WebKit-CSP');
        
        return $response;
    }
} 