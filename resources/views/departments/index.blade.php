@extends('layouts.app')
@section('title', 'Departments')

@section('content')
    <x-page-header title="Departments" subtitle="Teams in the organisation and whether they accept new employees."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Departments' => null]">
        @can('department.create')
            <x-slot:actions>
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add department
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
                        <th>Department</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $index => $department)
                        <tr>
                            <td class="cell-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="icon-tile tile-amber" style="width: 34px; height: 34px; font-size: 1rem;"><i class="bi bi-diagram-3"></i></span>
                                    <span class="cell-primary">{{ $department->name }}</span>
                                </div>
                            </td>
                            <td><span class="code-chip">{{ $department->code }}</span></td>
                            <td>
                                @if ($department->description)
                                    <span class="cell-muted text-truncate-2">{{ $department->description }}</span>
                                @else
                                    <span class="cell-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($department->is_active === true)
                                    <span class="status-pill is-success">Active</span>
                                @else
                                    <span class="status-pill is-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @can('department.update')
                                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state icon="diagram-3" title="No departments yet">
                                    <p>Create your first department to start organising employees.</p>
                                    @can('department.create')
                                        <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Add department
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
@endsection
