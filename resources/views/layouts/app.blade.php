<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | HRMS</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/scss/app.scss'])
</head>
<body>
    <div class="app-shell">
        <aside class="app-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="appSidebar" aria-label="Main navigation">
            @include('layouts.partials.sidebar')
        </aside>

        <div class="app-main">
            @include('layouts.partials.topbar')

            <main class="app-content">
                @include('layouts.partials.alerts')
                @yield('content')
            </main>

            <footer class="app-footer d-flex flex-wrap justify-content-between gap-2">
                <span>&copy; {{ now()->year }} HRMS</span>
                <span>Human Resource Management System</span>
            </footer>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>
