<header class="topbar">
    <div class="d-flex align-items-center gap-3 min-w-0">
        <button type="button" class="icon-btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#appSidebar" aria-controls="appSidebar" aria-label="Open menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="min-w-0">
            <p class="topbar-title text-truncate">@yield('title', 'Dashboard')</p>
            <div class="topbar-date d-none d-sm-block">
                {{ now()->timezone('Asia/Kolkata')->format('l, j F Y') }}
            </div>
        </div>
    </div>

    <div class="dropdown">
        <button class="user-menu-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <x-avatar :name="auth()->user()->name" />
            <span class="d-none d-md-block">
                <span class="user-name d-block">{{ auth()->user()->name }}</span>
                <span class="user-role d-block"><x-role-label :role="auth()->user()->role?->name" /></span>
            </span>
            <i class="bi bi-chevron-down small text-secondary d-none d-md-inline"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li class="dropdown-header-user">
                <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                <div class="small text-secondary text-truncate">{{ auth()->user()->email }}</div>
                <span class="badge text-bg-primary mt-2"><x-role-label :role="auth()->user()->role?->name" /></span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('password.change') }}">
                    <i class="bi bi-key"></i> Change password
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
