<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        // Server-side only check - no AJAX needed
        if (Auth::check()) {
            // Add headers to prevent caching
            header("Cache-Control: no-cache, no-store, must-revalidate");
            return $this->redirectToDashboard(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        return $this->redirectToDashboard($user);
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

    /**
     * Redirect user to appropriate dashboard based on access level
     */
    private function redirectToDashboard($user): RedirectResponse
    {
        switch ($user->user_Access) {
            case 'Superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'ERB Admin':
                return redirect()->route('erb.dashboard');
            case 'IACUC Admin':
                return redirect()->route('iacuc.dashboard');
            case 'ERB Reviewer':
                return redirect()->route('erb-reviewer.dashboard');
            case 'IACUC Reviewer':
                return redirect()->route('iacuc-reviewer.dashboard');
            case 'Principal Investigator':
                return redirect()->route('student.dashboard');
            default:
                // Logout and redirect to login with error for invalid access level
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['user_Access' => 'Invalid user access level. Please contact administrator.']);
        }
    }
}