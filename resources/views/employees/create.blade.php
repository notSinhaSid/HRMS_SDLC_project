@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Add Employee</h1>
        <form action="{{ route('employees.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" id="user_id" class="form-select @error('user_id')
                    is-invalid
                @enderror">
                    <option value="">Select User</option>
                    @foreach ($availableUsers as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $employee->user_id ?? '') == $user->id)>{{$user->name}}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @include('employees.partials._form')

            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
@endsection