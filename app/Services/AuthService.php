<?php

namespace App\Services;

use App\Enums\LoginResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    private function throttleKey(string $email, string $ip): string
    {
        return Str::lower($email).'|'.$ip;
    }

    public function login(array $data, string $ip): LoginResult
    {
        $key = $this->throttleKey($data['email'], $ip);
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return LoginResult::LockedOut;
        }

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            RateLimiter::hit($key, 60);

            return LoginResult::InvalidCredentials;
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();

            return LoginResult::Deactivated;
        }

        RateLimiter::clear($key);

        return LoginResult::Success;
    }

    public function lockoutSeconds(string $email, string $ip): int
    {
        return RateLimiter::availableIn($this->throttleKey($email, $ip));
    }
}
