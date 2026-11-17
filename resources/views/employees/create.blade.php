@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="card mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h1 class="h4">Add Employee</h1>
        <form action="{{ route('employees.store') }}" method="post">
            @csrf
            @include('employees.partials._form')

            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
@endsection