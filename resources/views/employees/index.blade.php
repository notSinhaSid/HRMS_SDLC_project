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
                <td>{{ $employee->date_of_joining?->toFormattedDateString() ?? 'To be added.' }}</td>
                
                <td>
                    @can('employee.update')
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                        @if ($employee->user->status === 'active')
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#offboardModal"
                                    data-action="{{ route('employees.offboard', $employee) }}"
                                    data-name="{{ $employee->user->name }}"
                                    data-joining={{ $employee->date_of_joining->format('Y-m-d') }}>
                                Offboard
                            </button>
                        @endif
                    @endcan
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No employess yet.</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
<div class="modal fade" id="offboardModal" tabindex="-1" aria-labelledby="offboardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="offboardModalLabel">Offboard employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Offboard <strong class="employee-name"></strong>? Their account will be deactivated immediately.</p>
                    <label for="date_of_leaving" class="form-label">Date of leaving</label>
                    <input type="date" name="date_of_leaving" id="date_of_leaving"
                        class="form-control @error('date_of_leaving') is-invalid @enderror"
                        value="{{ old('date_of_leaving') }}" required>
                    @error('date_of_leaving')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Offboard</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection