<div class="sidebar">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="sidebar-brand flex-grow-1">
            <x-logo :size="36" />
            <span>
                <span class="brand-name">HRMS</span>
                <span class="brand-tagline">People workspace</span>
            </span>
        </a>
        <button type="button" class="btn-close btn-close-white me-3 d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Close menu"></button>
    </div>

    <div class="sidebar-body">
        <div class="sidebar-section">Overview</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
        </ul>

        @canany(['employee.view', 'employee.create', 'department.view', 'designation.view'])
            <div class="sidebar-section">Organization</div>
            <ul class="sidebar-nav">
                @can('employee.view')
                    <li>
                        <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Employees
                        </a>
                    </li>
                @endcan
                @can('department.view')
                    <li>
                        <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3"></i> Departments
                        </a>
                    </li>
                @endcan
                @can('designation.view')
                    <li>
                        <a href="{{ route('designations.index') }}" class="nav-link {{ request()->routeIs('designations.*') ? 'active' : '' }}">
                            <i class="bi bi-person-badge"></i> Designations
                        </a>
                    </li>
                @endcan
            </ul>
        @endcanany

        @can('employee.create')
            <div class="sidebar-section">Administration</div>
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-person-plus"></i> Add user
                    </a>
                </li>
            </ul>
        @endcan

        <div class="sidebar-section">Account</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('password.change') }}" class="nav-link {{ request()->routeIs('password.change') ? 'active' : '' }}">
                    <i class="bi bi-key"></i> Change password
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <x-avatar :name="auth()->user()->name" size="sm" />
        <div class="min-w-0 overflow-hidden">
            <div class="user-name text-truncate">{{ auth()->user()->name }}</div>
            <div class="user-email text-truncate">{{ auth()->user()->email }}</div>
        </div>
    </div>
</div>
