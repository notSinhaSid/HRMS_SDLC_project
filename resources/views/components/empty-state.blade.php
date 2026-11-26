@props(['icon' => 'inbox', 'title'])
<div class="empty-state">
    <span class="empty-icon"><i class="bi bi-{{ $icon }}"></i></span>
    <h3>{{ $title }}</h3>
    @if ($slot->isNotEmpty())
        <div>{{ $slot }}</div>
    @endif
</div>
