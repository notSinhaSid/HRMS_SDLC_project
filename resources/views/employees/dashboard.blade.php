@extends('layouts.app')
@section('title', 'Dashboard')

@php
    $user = auth()->user();
    $employee = $user->employee;
    $hour = now()->timezone('Asia/Kolkata')->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
@endphp

@section('content')
    <div class="card welcome-card mb-4">
        <div class="card-body">
            <span class="badge rounded-pill bg-white bg-opacity-10 text-white fw-medium mb-3">
                <x-role-label :role="$user->role?->name" />
            </span>
            <h2>{{ $greeting }}, {{ \Illuminate\Support\Str::of($user->name)->before(' ') }}</h2>
            <p class="mb-0">Here's your HRMS workspace. Pick up where you left off.</p>
            <x-illustrations.people class="welcome-art" />
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <h2 class="h6 text-uppercase text-secondary fw-semibold small mb-3" style="letter-spacing: .06em;">Quick actions</h2>
            <div class="row g-3">
                @can('employee.view')
                    <div class="col-md-6">
                        <a href="{{ route('employees.index') }}" class="card quick-action">
                            <span class="icon-tile tile-blue"><i class="bi bi-people"></i></span>
                            <span>
                                <span class="qa-title d-block">Employees</span>
                                <span class="qa-text">View and manage employee records</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                @endcan
                @can('employee.create')
                    <div class="col-md-6">
                        <a href="{{ route('employees.create') }}" class="card quick-action">
                            <span class="icon-tile tile-teal"><i class="bi bi-person-vcard"></i></span>
                            <span>
                                <span class="qa-title d-block">Add employee</span>
                                <span class="qa-text">Create an employee profile for a user</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('users.create') }}" class="card quick-action">
                            <span class="icon-tile tile-violet"><i class="bi bi-person-plus"></i></span>
                            <span>
                                <span class="qa-title d-block">Add user</span>
                                <span class="qa-text">Create a login and email a temporary password</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                @endcan
                @can('department.view')
                    <div class="col-md-6">
                        <a href="{{ route('departments.index') }}" class="card quick-action">
                            <span class="icon-tile tile-amber"><i class="bi bi-diagram-3"></i></span>
                            <span>
                                <span class="qa-title d-block">Departments</span>
                                <span class="qa-text">Organise teams and their status</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                @endcan
                @can('designation.view')
                    <div class="col-md-6">
                        <a href="{{ route('designations.index') }}" class="card quick-action">
                            <span class="icon-tile tile-rose"><i class="bi bi-person-badge"></i></span>
                            <span>
                                <span class="qa-title d-block">Designations</span>
                                <span class="qa-text">Maintain job titles</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                @endcan
                <div class="col-md-6">
                    <a href="{{ route('password.change') }}" class="card quick-action">
                        <span class="icon-tile tile-blue"><i class="bi bi-key"></i></span>
                        <span>
                            <span class="qa-title d-block">Change password</span>
                            <span class="qa-text">Keep your account secure</span>
                        </span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <h2 class="h6 text-uppercase text-secondary fw-semibold small mb-3" style="letter-spacing: .06em;">My profile</h2>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <x-avatar :name="$user->name" size="lg" />
                        <div class="min-w-0">
                            <div class="fw-semibold text-dark text-truncate">{{ $user->name }}</div>
                            <div class="small text-secondary text-truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                    <dl class="info-list">
                        <div>
                            <dt>Role</dt>
                            <dd><x-role-label :role="$user->role?->name" /></dd>
                        </div>
                        <div>
                            <dt>Employee code</dt>
                            <dd>
                                @if ($employee?->employee_code)
                                    <span class="code-chip">{{ $employee->employee_code }}</span>
                                @else
                                    <span class="text-secondary">Not assigned</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt>Department</dt>
                            <dd>{{ $employee?->department?->name ?? 'Not assigned' }}</dd>
                        </div>
                        <div>
                            <dt>Designation</dt>
                            <dd>{{ $employee?->designation?->name ?? 'Not assigned' }}</dd>
                        </div>
                        <div>
                            <dt>Joined</dt>
                            <dd>{{ $employee?->date_of_joining?->toFormattedDateString() ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
