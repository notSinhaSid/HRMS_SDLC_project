<div class="brand-logo text-white">
    <h4 class="fs-3 p-3">HRMS</h4>
</div>

<nav class="sidebar-nav">
    <ul class="nav flex-column">
        <li><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active': '' }}">Dashboard</a></li>
        @can('employee.create')
             <li><a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active': '' }}">Add user</a></li>
             <li><a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active': '' }}">Departments</a></li>
             <li><a href="{{ route('designations.index') }}" class="nav-link {{ request()->routeIs('designations.index') ? 'active': '' }}">Designations</a></li>
        @endcan
    </ul>
</nav>