@extends('layouts.guest')
@section('title', 'Password Reset')
@section('card-title', 'Reset Password')
@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" value="{{ old('email', $email) }}" name="email" readonly>
            
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control @error('password')
                is-invalid
            @enderror" name="password" id="password" placeholder="Your new password" required autofocus>
            @error('password')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm your new password" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
@endsection
