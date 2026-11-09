<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LoginResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated(), $request->ip());

        if ($result === LoginResult::Success) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        if ($result === LoginResult::Deactivated) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $seconds = $result === LoginResult::LockedOut ? $this->authService->lockoutSeconds($request->email, $request->ip()) : 0;

        return match ($result) {
            LoginResult::InvalidCredentials => back()->withErrors(['message' => __('messages.auth.invalid_credentials')])->onlyInput('email'),
            LoginResult::LockedOut => back()->withErrors(['message' => __('messages.auth.lockedout', ['seconds' => $seconds])])->onlyInput('email'),
            LoginResult::Deactivated => back()->withErrors(['message' => __('messages.auth.deactivated')])->onlyInput('email'),
            LoginResult::Success => redirect()->intended(route('dashboard'))
        };

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
