@extends('layouts.guest')

@section('title', 'Password Reset')
@section('icon', 'shield-lock')
@section('card-title', 'Set a new password')
@section('sub-text', 'Use at least 8 characters with upper and lower case letters.')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" id="email" name="email"
                   value="{{ old('email', $email) }}" readonly>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New password</label>
            <div class="input-group has-validation">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                       placeholder="Your new password" autocomplete="new-password" required autofocus>
                <button type="button" class="btn btn-password-toggle" data-password-toggle="#password" aria-label="Show password">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm new password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                   placeholder="Repeat the new password" autocomplete="new-password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">Update password</button>
    </form>

    <a href="{{ route('login') }}" class="d-inline-flex align-items-center gap-2 small text-decoration-none mt-4">
        <i class="bi bi-arrow-left"></i> Back to login
    </a>
@endsection
