@props(['type' => 'success', 'message' => ''])

@php
    $baseClasses = 'fixed top-5 right-5 z-50 px-5 py-3 rounded-lg shadow-lg text-sm flex items-center gap-3';
    $typeClasses = match ($type) {
        'success' => 'bg-green-600 text-white',
        'error' => 'bg-red-600 text-white',
        'warning' => 'bg-yellow-500 text-white',
        default => 'bg-gray-600 text-white',
    };
    $icon = match ($type) {
        'success' => 'fas fa-check-circle',
        'error' => 'fas fa-times-circle',
        'warning' => 'fas fa-exclamation-triangle',
        default => 'fas fa-info-circle',
    };
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2" class="{{ $baseClasses }} {{ $typeClasses }}">
    <i class="{{ $icon }}"></i>
    <span>{{ $message }}</span>
</div>
