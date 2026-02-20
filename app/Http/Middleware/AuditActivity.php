<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && $request->method() == 'GET') {
            // Filter out common assets and unwanted paths if necessary
            $path = $request->path();
            if (!str_starts_with($path, 'livewire') && !str_starts_with($path, '_debugbar')) {
                \App\Models\Audit::create([
                    'user_id' => auth()->id(),
                    'event' => 'view',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                ]);
            }
        }

        return $response;
    }
}
