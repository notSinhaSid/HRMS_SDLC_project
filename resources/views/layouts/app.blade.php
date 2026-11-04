<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | HRMS</title>
    @vite(['resources/scss/app.scss'])
</head>
<body>
    <div class="app-shell">
        <aside class="app-sidebar">
            @include('layouts.partials.sidebar')
        </aside>
        <div class="app-main">
            @include('layouts.partials.topbar')
            <main class="app-content">
                @include('layouts.partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>
    
    @vite(['resources/js/app.js'])
</body>
</html>