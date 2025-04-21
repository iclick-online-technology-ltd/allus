<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberMe = $request->has('remember');

        if (Auth::attempt($credentials, $rememberMe)) {
            $user = Auth::user();
            $request->session()->regenerate();

            return redirect()->route('dashboard.index')->with('success', 'You have Successfully logged in!!');

        } else {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            throw ValidationException::withMessages([
                'inactive' => 'You have entered invalid credentials',
                //                'password' => 'You have entered invalid credentials',
            ]);

        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'You have successfully logged out.');
    }
}
