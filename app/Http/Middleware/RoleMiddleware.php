<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if the role matches
        if (strtolower($user->role) !== strtolower($role)) {
            abort(403, 'Forbidden: ' . ucfirst($role) . ' access only.');
        }

        return $next($request);
    }
}
