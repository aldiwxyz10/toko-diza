<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cek apakah user dengan email tersebut ada
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => __('passwords.user')]);
        }

        // Generate token reset password secara manual
        $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);

        // Langsung redirect ke halaman reset password (Bypass email log)
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
}
