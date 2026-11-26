@props(['size' => 36])
@php($gradientId = 'hrmsLogo'.\Illuminate\Support\Str::random(6))
{{-- HRMS brand mark: an "H" whose crossbar carries a person (head + shoulders). --}}
<svg {{ $attributes->merge(['class' => 'brand-mark']) }} width="{{ $size }}" height="{{ $size }}" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <defs>
        <linearGradient id="{{ $gradientId }}" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#3B82F6"/>
            <stop offset="1" stop-color="#4F46E5"/>
        </linearGradient>
    </defs>
    <rect width="40" height="40" rx="10" fill="url(#{{ $gradientId }})"/>
    <rect x="9" y="10" width="5" height="20" rx="2.5" fill="#fff"/>
    <rect x="26" y="10" width="5" height="20" rx="2.5" fill="#fff"/>
    <path d="M13 21.5h14" stroke="#fff" stroke-width="3.5" stroke-linecap="round"/>
    <circle cx="20" cy="14.5" r="3" fill="#22C3A6"/>
</svg>
