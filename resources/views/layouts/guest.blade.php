<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRMS') | HRMS</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/scss/app.scss'])
</head>
<body>
    <div class="guest-wrapper">
        {{-- Brand panel (lg and up) --}}
        <aside class="guest-aside">
            <div class="guest-brand">
                <x-logo :size="40" />
                <span>HRMS</span>
            </div>

            <div>
                <h2>People, attendance and payroll in one place.</h2>
                <p class="lead mt-3">A single workspace for HR, managers and employees.</p>
                <x-illustrations.workspace class="guest-art" />
                <ul class="guest-features">
                    <li><i class="bi bi-people"></i> Employee records and org structure</li>
                    <li><i class="bi bi-shield-lock"></i> Role-based access for every team</li>
                    <li><i class="bi bi-clock-history"></i> Audit trail for critical changes</li>
                </ul>
            </div>

            <div class="guest-copy">&copy; {{ now()->year }} HRMS. All rights reserved.</div>
        </aside>

        {{-- Form column --}}
        <main class="guest-main">
            <div class="guest-card">
                <div class="guest-mobile-brand">
                    <x-logo :size="34" />
                    <span>HRMS</span>
                </div>

                @hasSection('icon')
                    <span class="guest-icon"><i class="bi bi-@yield('icon')"></i></span>
                @endif

                <h1>@yield('card-title', 'HRMS')</h1>
                @hasSection('sub-text')
                    <p class="guest-subtitle">@yield('sub-text')</p>
                @endif

                @include('layouts.partials.alerts')
                @yield('content')
            </div>
        </main>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>
