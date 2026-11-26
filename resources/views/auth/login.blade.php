@extends('layouts.guest')

@section('title', 'Login')
@section('card-title', 'Welcome back')
@section('sub-text', 'Sign in to your HRMS account to continue.')

@section('content')
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <div class="input-group has-validation">
                <span class="input-group-text bg-white"><i class="bi bi-envelope text-secondary"></i></span>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" placeholder="you@company.com" autocomplete="username" autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label">Password</label>
                <a href="{{ route('password.request') }}" class="small text-decoration-none mb-2">Forgot password?</a>
            </div>
            <div class="input-group has-validation">
                <span class="input-group-text bg-white"><i class="bi bi-lock text-secondary"></i></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                       placeholder="Enter your password" autocomplete="current-password">
                <button type="button" class="btn btn-password-toggle" data-password-toggle="#password" aria-label="Show password">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
            Sign in <i class="bi bi-arrow-right ms-1"></i>
        </button>
    </form>

    <p class="text-secondary small text-center mt-4 mb-0">
        <i class="bi bi-info-circle me-1"></i> Accounts are created by HR. Contact them if you need access.
    </p>
@endsection
