@extends('layouts.guest')

@section('title', 'Login')
@section('card-title', 'Login')
@section('sub-text', 'Welcome to HRMS')
@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email" autofocus>
            
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <a href="{{ route('password.request') }}" class="mt-3 d-block">Forgot Password?</a>
@endsection
