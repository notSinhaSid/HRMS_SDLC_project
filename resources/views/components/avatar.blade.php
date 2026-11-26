@props(['name' => '', 'size' => null])
@php
    $initials = collect(preg_split('/\s+/', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');
@endphp
<span {{ $attributes->class(['avatar', 'avatar-'.$size => $size]) }} aria-hidden="true">{{ $initials ?: '?' }}</span>
