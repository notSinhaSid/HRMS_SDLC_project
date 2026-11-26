@extends('layouts.guest')

@section('title', 'Forgot Password')
@section('icon', 'key')
@section('card-title', 'Forgot password?')
@section('sub-text', "Enter your account email and we'll send you a link to reset your password.")

@section('content')
    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <div class="input-group has-validation">
                <span class="input-group-text bg-white"><i class="bi bi-envelope text-secondary"></i></span>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" placeholder="you@company.com" autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">Send reset link</button>
    </form>

    <a href="{{ route('login') }}" class="d-inline-flex align-items-center gap-2 small text-decoration-none mt-4">
        <i class="bi bi-arrow-left"></i> Back to login
    </a>
@endsection
