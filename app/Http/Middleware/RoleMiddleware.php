<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('Role Check:', [
            'user_id' => $user?->id,
            'user_role' => $user?->role,
            'required_role' => $role
        ]);

        if (!$user || $user->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
