<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HRMS') | HRMS</title>
    @vite(['resources/scss/app.scss'])
</head>
<body>
    <main class="guest-wrapper min-vh-100 d-flex align-items-center justify-content-center">
        <div class=" card guest-card">

            <div class="card-body shadow p-3 bg-body-tertiary rounded">
                <div class="card-title">
                    <h4>@yield('card-title', 'HRMS')</h4>
                </div>
                @hasSection('sub-text')
                    <small class="card-text mb-2">
                        @yield('sub-text')
                    </small>
                @endif
                @include('layouts.partials.alerts')
                @yield('content')
            </div>
        </div>
    </main>
    @vite(['resources/js/guest.js'])
</body>
</html>