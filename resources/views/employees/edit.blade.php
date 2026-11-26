@extends('layouts.app')
@section('title', 'Edit Employee')

@section('content')
    <x-page-header title="Edit employee" :subtitle="$employee->user->name"
                   :breadcrumbs="['Dashboard' => route('dashboard'), 'Employees' => route('employees.index'), 'Edit' => null]" />

    <form action="{{ route('employees.update', $employee) }}" method="post" class="card form-card">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-section-title">Account</div>
            <div class="d-flex align-items-center gap-3 p-3 mb-4 rounded border bg-light">
                <x-avatar :name="$employee->user->name" />
                <div class="min-w-0">
                    <div class="fw-semibold text-dark text-truncate">{{ $employee->user->name }}</div>
                    <div class="small text-secondary text-truncate">{{ $employee->user->email }}</div>
                </div>
                @if ($employee->employee_code)
                    <span class="code-chip ms-auto">{{ $employee->employee_code }}</span>
                @endif
            </div>

            @include('employees.partials._form')
        </div>
        <div class="card-footer">
            <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i> Save changes</button>
        </div>
    </form>
@endsection
