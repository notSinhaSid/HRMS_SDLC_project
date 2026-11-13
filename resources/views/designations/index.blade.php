@extends('layouts.app')
@section('title', 'Designations')

@section('content')
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Designation name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($designations as $index => $designation)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $designation->name }}</td>
                <td>
                    <a href="{{ route('designations.edit', $designation->id) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No designations yet.</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('designations.create') }}" class="btn btn-primary">Add Designation</a>
@endsection