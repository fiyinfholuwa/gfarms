<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth_new.login');
    }

    /**
     * Handle an incoming authentication request.
     */

public function store(LoginRequest $request): RedirectResponse
{
    // Authenticate user (this will check credentials)
    $request->authenticate();

    // Check if inactive **before** session regenerate, so we can redirect back with errors
    if (Auth::user()->account_status === 'inactive') {
        Auth::logout();

        // Throw a validation exception on the "email" field (or wherever you prefer)
        throw ValidationException::withMessages([
            'email' => ['Account Suspended/Blocked — Kindly reach out to Admin.'],
        ]);
    }


    $request->session()->regenerate();
    session()->forget('url.intended');

    return redirect()->intended(route('check_login', absolute: true));
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
