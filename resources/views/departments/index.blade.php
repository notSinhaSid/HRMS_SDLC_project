@extends('layouts.app')
@section('title', 'Departments')

@section('content')

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Department name</th>
            <th>Department code</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($departments as $index => $department)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->code }}</td>
                <td>{{ $department->description }}</td>
                <td>
                    @if ($department->is_active === true)
                        <span class="badge rounded-pill text-bg-success">Active</span>
                    @else
                        <span class="badge rounded-pill text-bg-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No departments yet.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection