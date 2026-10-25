@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
  <div class="container">
        <form action="{{ route('password.change.update') }}" method="post">
            @csrf
                <div class="form-group">
                  <label for="current_password">Current Password</label>
                  <input type="password" name="current_password" id="current_password" class="@error('current_password') is-invalid @enderror form-control">
                  
                  @error('current_password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="password">New Password</label>
                  <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control">
                  
                  @error('password')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
                <div class="form-group">
                  <label for="password_confirmation">Confirm New Password</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
              </div>

                <button type="submit" class="btn btn-md btn-outline-success">Change password</button>
            
        </form>

        <form action="{{ route('logout') }}" method="post">
            <button type="submit">
                logout button
            </button>
        </form>
    </div>
@endsection
