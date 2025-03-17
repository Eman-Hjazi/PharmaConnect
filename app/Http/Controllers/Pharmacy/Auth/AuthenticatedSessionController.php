<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PharmacyLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('pharmacy.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(PharmacyLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('pharmacy')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('pharmacy.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('pharmacy')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
