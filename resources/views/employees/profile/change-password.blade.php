@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <x-page-header title="Change password" subtitle="Use at least 8 characters with upper and lower case letters."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Change password' => null]" />

    @if (auth()->user()->must_reset_password)
        <div class="alert alert-warning d-flex gap-2 form-card form-card-sm" role="alert">
            <i class="bi bi-shield-exclamation"></i>
            <div>You're using a temporary password. Set a new one to continue.</div>
        </div>
    @endif

    <form action="{{ route('password.change.update') }}" method="post" class="card form-card form-card-sm">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current password</label>
                <div class="input-group has-validation">
                    <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                           class="form-control @error('current_password') is-invalid @enderror">
                    <button type="button" class="btn btn-password-toggle" data-password-toggle="#current_password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label for="password" class="form-label">New password</label>
                <div class="input-group has-validation">
                    <input type="password" name="password" id="password" autocomplete="new-password"
                           class="form-control @error('password') is-invalid @enderror">
                    <button type="button" class="btn btn-password-toggle" data-password-toggle="#password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Confirm new password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="bi bi-shield-check me-1"></i> Update password</button>
        </div>
    </form>
@endsection
