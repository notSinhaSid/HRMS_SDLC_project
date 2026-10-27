@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="card mx-auto" style="max-width:480px;">
    <div class="card-body">
        <h1 class="h4 mb-3">Change password</h1>
        <form action="{{ route('password.change.update') }}" method="post">
            @csrf
                <div class="mb-3">
                    <label for="current_password">Current password</label>
                    <input type="password" name="current_password" id="current_password" class="@error('current_password') is-invalid @enderror form-control">
                    
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password">New password</label>
                    <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control">
                    
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Confirm new password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-md btn-outline-primary mt-2">Change password</button>
        </form>
    </div>
    
</div>
@endsection
