@extends('layouts.app')
@section('title', 'Add Employee')

@section('content')
    <x-page-header title="Add employee" subtitle="Create an employee profile for an existing user account."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Employees' => route('employees.index'), 'Add' => null]" />

    <form action="{{ route('employees.store') }}" method="post" class="card form-card">
        @csrf
        <div class="card-body">
            <div class="form-section-title">Account</div>
            <div class="mb-4">
                <label for="user_id" class="form-label">User <span class="required">*</span></label>
                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                    <option value="">Select a user</option>
                    @foreach ($availableUsers as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $employee->user_id ?? '') == $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Only active users without an employee profile are listed.</div>
            </div>

            @include('employees.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Add employee</button>
        </div>
    </form>
@endsection
