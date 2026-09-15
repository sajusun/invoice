@props([
    'label' => 'Usage',
    'used'  => 0,
    'limit' => null, // null means unlimited
    'unit'  => 'items',
])

@php
    $isUnlimited = $limit === null || $limit === 0;
    $percentage = $isUnlimited ? 0 : min(100, round(($used / $limit) * 100));

    $barColor = match(true) {
        $percentage >= 90 => 'bg-rose-500',
        $percentage >= 70 => 'bg-amber-500',
        default           => 'bg-blue-600',
    };
@endphp

<div class="space-y-1.5">
    <div class="flex items-center justify-between text-xs">
        <span class="font-medium text-gray-700">{{ $label }}</span>
        <span class="font-semibold text-gray-900">
            @if($isUnlimited)
                {{ number_format($used) }} {{ $unit }} <span class="text-emerald-600 font-normal">(Unlimited)</span>
            @else
                {{ number_format($used) }} / {{ number_format($limit) }} {{ $unit }}
                <span class="text-gray-400 font-normal">({{ $percentage }}%)</span>
            @endif
        </span>
    </div>
    @if(!$isUnlimited)
        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
        </div>
    @endif
</div>
