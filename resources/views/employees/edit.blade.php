@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Edit Employee</h1>
        <form action="{{ route('employees.update', $employee) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">User</label>
                <input type="text" class="form-control" value="{{ $employee->user->name }}" readonly>
            </div>
            @include('employees.partials._form') 
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
@endsection