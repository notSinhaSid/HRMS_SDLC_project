@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Employee name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Employee code</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Date of birth</th>
            <th>Date of joining</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($employees as $index => $employee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $employee->user->name }}</td>
                <td>{{ $employee->department->name ?? 'Not assigned yet.' }}</td>
                <td>{{ $employee->designation->name ?? 'Not assigned yet.' }}</td>
                <td>{{ $employee->employee_code }}</td>
                <td>{{ $employee->phone ?? 'To be added.' }}</td>
                <td>{{ $employee->address ?? 'To be added.' }}</td>
                <td>{{ $employee->gender ?? 'To be added.' }}</td>
                <td>{{ $employee->date_of_birth->toFormattedDateString() ?? 'To be added.' }}</td>
                <td>{{ $employee->date_of_joining->toFormattedDateString() ?? 'To be added.' }}</td>
                
                <td>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No departments yet.</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>

@endsection