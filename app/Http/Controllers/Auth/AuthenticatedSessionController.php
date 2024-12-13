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
        $request->authenticate();

        $request->session()->regenerate();
        
        // Store user data in session
        $user = Auth::user();
        $request->session()->put('user_data', [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
        ]);

        return redirect()
            ->route($user->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')
            ->with('auth_data', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ],
                'timestamp' => now()->timestamp
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear the session first
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Then logout the user
        Auth::guard('web')->logout();

        // Perform a full redirect with cache busting
        return redirect('/?logout=' . time())
            ->with([
                'auth.logout' => true,
                'forceReload' => true,
                'clearAdminLayout' => true
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
