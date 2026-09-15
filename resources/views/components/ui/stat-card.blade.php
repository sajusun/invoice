@props([
    'title'     => '',
    'value'     => '0',
    'icon'      => 'fa-solid fa-chart-simple',
    'trend'     => null,
    'trendType' => 'positive', // positive, negative, neutral
    'color'     => 'blue',     // blue, emerald, amber, purple, indigo, rose
    'subtitle'  => null,
])

@php
    $colorClasses = match($color) {
        'emerald', 'green' => [
            'bg'    => 'bg-emerald-50 text-emerald-600',
            'border'=> 'border-emerald-100',
            'glow'  => 'hover:border-emerald-200 hover:shadow-emerald-500/5',
        ],
        'amber', 'yellow'  => [
            'bg'    => 'bg-amber-50 text-amber-600',
            'border'=> 'border-amber-100',
            'glow'  => 'hover:border-amber-200 hover:shadow-amber-500/5',
        ],
        'purple'           => [
            'bg'    => 'bg-purple-50 text-purple-600',
            'border'=> 'border-purple-100',
            'glow'  => 'hover:border-purple-200 hover:shadow-purple-500/5',
        ],
        'rose', 'red'      => [
            'bg'    => 'bg-rose-50 text-rose-600',
            'border'=> 'border-rose-100',
            'glow'  => 'hover:border-rose-200 hover:shadow-rose-500/5',
        ],
        'indigo'           => [
            'bg'    => 'bg-indigo-50 text-indigo-600',
            'border'=> 'border-indigo-100',
            'glow'  => 'hover:border-indigo-200 hover:shadow-indigo-500/5',
        ],
        default            => [
            'bg'    => 'bg-blue-50 text-blue-600',
            'border'=> 'border-blue-100',
            'glow'  => 'hover:border-blue-200 hover:shadow-blue-500/5',
        ],
    };
@endphp

<div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm {{ $colorClasses['glow'] }} transition-all duration-200 hover:-translate-y-0.5">
    <div class="flex items-center justify-between gap-4">
        <div class="space-y-1">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $title }}</span>
            <div class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                {{ $value }}
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl {{ $colorClasses['bg'] }} flex items-center justify-center text-xl flex-shrink-0 shadow-inner">
            <i class="{{ $icon }}"></i>
        </div>
    </div>

    @if($trend || $subtitle)
        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
            @if($trend)
                <span class="inline-flex items-center gap-1 font-semibold {{ $trendType === 'positive' ? 'text-emerald-600' : ($trendType === 'negative' ? 'text-rose-600' : 'text-gray-500') }}">
                    <i class="fa-solid {{ $trendType === 'positive' ? 'fa-arrow-trend-up' : ($trendType === 'negative' ? 'fa-arrow-trend-down' : 'fa-minus') }}"></i>
                    {{ $trend }}
                </span>
            @endif
            @if($subtitle)
                <span class="text-gray-400 truncate">{{ $subtitle }}</span>
            @endif
        </div>
    @endif
</div>
