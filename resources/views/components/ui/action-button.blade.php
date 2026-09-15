@props([
    'variant' => 'primary', // primary, secondary, outline, danger, ghost
    'size'    => 'md',      // sm, md, lg
    'icon'    => null,
    'href'    => null,
    'type'    => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed rounded-xl';

    $sizeClasses = match($size) {
        'sm'    => 'px-3 py-1.5 text-xs gap-1.5',
        'lg'    => 'px-5 py-3 text-base gap-2.5 shadow-md',
        default => 'px-4 py-2 text-sm gap-2 shadow-sm',
    };

    $variantClasses = match($variant) {
        'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-800 focus:ring-gray-300 border border-gray-200',
        'outline'   => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 focus:ring-blue-500 shadow-sm',
        'danger'    => 'bg-rose-600 hover:bg-rose-700 text-white focus:ring-rose-500 shadow-sm',
        'ghost'     => 'bg-transparent hover:bg-gray-100 text-gray-600 focus:ring-gray-200',
        default     => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 shadow-sm',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif
