@extends('layouts.guest')
@section('title', 'Forgot Password')
@section('card-title', 'Forgot Password')
@section('sub-text', "Let's recover your password")
@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="mt-2">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email')
                is-invalid
            @enderror" id="email" value="{{ old('email') }}" name="email" autofocus>
            @error('email')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
        <a href="{{ route('login') }}" class="btn btn-sm">Back to Login</a>
    </form>
@endsection
