<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; // Make sure to import your User model

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if the user is authenticated at all
        if (!Auth::check()) {
            // If not authenticated, redirect to the login page
            return redirect()->route('login');
        }

        // 2. Get the authenticated user.
        //    Auth::user() already returns the User model instance.
        /** @var \App\Models\User $user */ // <-- This PHPDoc hint is for Intelephense
        $user = Auth::user();

        // 3. Ensure a user object was actually returned (e.g., not null if session expired oddly)
        //    And then check if the user has any of the required roles.
        if (!$user || !$user->hasAnyRole($roles)) {
            // If unauthorized, abort with a 403 Forbidden error
            abort(403, 'Unauthorized action.');
            // Alternatively, you could redirect to a specific error page:
            // return redirect()->route('permission.denied');
        }

        // 4. If all checks pass, allow the request to proceed
        return $next($request);
    }
}