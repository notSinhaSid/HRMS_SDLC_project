<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $key = Str::lower($request->email).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts = 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors(['message' => "Too many attempts. Try again in {$seconds} seconds"])->onlyInput('email');
        }

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($key, $decaySeconds = 60);

            return back()->withErrors(['message' => 'Invalid credentials'])->onlyInput('email');
        }
        if (Auth::user()->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['message' => 'Account deactivated. Contact Support'])->onlyInput('email');
        }

        RateLimiter::clear($key);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));

    }

    public function dashboard()
    {
        return view('employees.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
