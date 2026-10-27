<div class="brand-logo text-white">
    <h4 class="fs-3 p-3">HRMS</h4>
</div>

<nav class="sidebar-nav">
    <ul class="nav flex-column">
        <li><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active': '' }}">Dashboard</a></li>
    </ul>
</nav>