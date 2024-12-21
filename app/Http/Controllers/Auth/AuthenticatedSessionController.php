<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // Authenticate the user
    $request->authenticate();

    // Regenerate session to prevent session fixation
    $request->session()->regenerate();

    // Check the user's role and redirect accordingly
    if (Auth::user()->role === 'Admin') {
        // Redirect to the 'product' route for Admin
        return redirect()->intended(route('product.index', absolute: false));
    }

    if (Auth::user()->role === 'Customer') {
        // Redirect to the 'dashboard' route for Customer
        return redirect()->intended(route('shop', absolute: false));
    }

    // Default fallback, if role doesn't match (optional)
    return redirect()->intended(route('myHome', absolute: false));  // Replace 'home' with your default route
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
