<div class="topbar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        </ol>
    </nav>
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ auth()->user()->name }}
            <span class="badge text-bg-primary ms-2">{{ auth()->user()->role->name }}</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('password.change') }}">Change password</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="dropdown-item text-danger">Logout</button>
            </form></li>
        </ul>
    </div>
</div>