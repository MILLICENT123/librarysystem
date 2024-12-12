<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;  // Corrected the syntax by adding a space after "use"
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated and has the correct role
        if (!auth()->check() || auth()->user()->role !== $role) {
            return redirect('/Homepage')->with('error', 'You do not have access to this page.');
        }

        return $next($request);
    }
}
