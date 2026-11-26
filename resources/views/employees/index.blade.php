@extends('layouts.app')
@section('title', 'Employees')

@section('content')
    <x-page-header title="Employees" subtitle="Everyone in the organisation, their team and role."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Employees' => null]">
        @can('employee.create')
            <x-slot:actions>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add employee
                </a>
            </x-slot:actions>
        @endcan
    </x-page-header>

    <div class="card table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 4rem;">#</th>
                        <th>Employee</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $index => $employee)
                        <tr>
                            <td class="cell-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <x-avatar :name="$employee->user->name" size="sm" class="avatar-soft" />
                                    <div class="min-w-0">
                                        <div class="cell-primary text-truncate">{{ $employee->user->name }}</div>
                                        <div class="cell-muted text-truncate">{{ $employee->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>@if ($employee->employee_code)<span class="code-chip">{{ $employee->employee_code }}</span>@else<span class="cell-muted">—</span>@endif</td>
                            <td>
                                @if ($employee->department)
                                    {{ $employee->department->name }}
                                @else
                                    <span class="cell-muted">Not assigned</span>
                                @endif
                            </td>
                            <td>
                                @if ($employee->designation)
                                    {{ $employee->designation->name }}
                                @else
                                    <span class="cell-muted">Not assigned</span>
                                @endif
                            </td>
                            <td class="text-nowrap">{{ $employee->date_of_joining?->toFormattedDateString() ?? '—' }}</td>
                            <td>
                                @if ($employee->user->status === 'active')
                                    <span class="status-pill is-success">Active</span>
                                @else
                                    <span class="status-pill is-muted">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @can('employee.update')
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    @if ($employee->user->status === 'active')
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#offboardModal"
                                                data-action="{{ route('employees.offboard', $employee) }}"
                                                data-name="{{ $employee->user->name }}"
                                                data-joining="{{ $employee->date_of_joining->format('Y-m-d') }}">
                                            <i class="bi bi-box-arrow-right"></i> Offboard
                                        </button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <x-empty-state icon="people" title="No employees yet">
                                    <p>Add an employee profile for an existing user to get started.</p>
                                    @can('employee.create')
                                        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Add employee
                                        </a>
                                    @endcan
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="offboardModal" tabindex="-1" aria-labelledby="offboardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form method="post" action="">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <div class="d-flex align-items-center gap-3">
                            <span class="icon-tile tile-rose"><i class="bi bi-box-arrow-right"></i></span>
                            <h5 class="modal-title" id="offboardModalLabel">Offboard employee</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">
                            Offboard <strong class="employee-name text-dark"></strong>? Their account will be deactivated immediately.
                        </p>
                        <label for="date_of_leaving" class="form-label">Date of leaving <span class="required text-danger">*</span></label>
                        <input type="date" name="date_of_leaving" id="date_of_leaving"
                               class="form-control @error('date_of_leaving') is-invalid @enderror"
                               value="{{ old('date_of_leaving') }}" required>
                        @error('date_of_leaving')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Offboard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
