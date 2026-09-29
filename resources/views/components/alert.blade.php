@props([
    'type' => 'success',
    'message' => null
])

@php
    $bgClass = match($type) {
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'danger', 'error' => 'bg-rose-50 border-rose-200 text-rose-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        default => 'bg-orange-50 border-orange-200 text-orange-900',
    };

    $icon = match($type) {
        'success' => '✓',
        'danger', 'error' => '✕',
        'warning' => '⚠',
        default => 'ℹ',
    };
@endphp

<div class="c-alert c-alert--{{ $type }} {{ $bgClass }}" role="alert">
    <div class="c-alert__icon">
        <span>{{ $icon }}</span>
    </div>
    <div class="c-alert__content">
        {{ $message ?? $slot }}
    </div>
    <button type="button" class="c-alert__close" onclick="this.closest('.c-alert').remove()" aria-label="Tutup notifikasi">
        &times;
    </button>
</div>
