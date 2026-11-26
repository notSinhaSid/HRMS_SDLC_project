@extends('layouts.app')
@section('title', 'Designations')

@section('content')
    <x-page-header title="Designations" subtitle="Job titles that can be assigned to employees."
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Designations' => null]">
        @can('designation.create')
            <x-slot:actions>
                <a href="{{ route('designations.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Add designation
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
                        <th>Designation</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($designations as $index => $designation)
                        <tr>
                            <td class="cell-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="icon-tile tile-rose" style="width: 34px; height: 34px; font-size: 1rem;"><i class="bi bi-person-badge"></i></span>
                                    <span class="cell-primary">{{ $designation->name }}</span>
                                </div>
                            </td>
                            <td class="text-end">
                                @can('designation.update')
                                    <a href="{{ route('designations.edit', $designation->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <x-empty-state icon="person-badge" title="No designations yet">
                                    <p>Add job titles such as "Software Engineer" or "HR Executive".</p>
                                    @can('designation.create')
                                        <a href="{{ route('designations.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i> Add designation
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
