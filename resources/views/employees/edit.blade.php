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
                <div class="mb-3">
                    <label for="date_of_leaving" class="form-date-label">Date of Leaving</label>
                    <input type="date" name="date_of_leaving" id="date_of_leaving" value="{{ old('date_of_leaving', $employee?->date_of_leaving?->format('Y-m-d')) }}" class="form-control @error('date_of_leaving')
                        is-invaild
                    @enderror">
                    @error('date_of_leaving')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div> 
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
@endsection