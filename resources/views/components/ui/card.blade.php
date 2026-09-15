@props([
    'title'    => null,
    'subtitle' => null,
    'icon'     => null,
    'action'   => null,
    'class'    => '',
])

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden {{ $class }}">
    @if($title || $action)
        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="space-y-0.5">
                @if($title)
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        @if($icon)
                            <i class="{{ $icon }} text-blue-600"></i>
                        @endif
                        {{ $title }}
                    </h3>
                @endif
                @if($subtitle)
                    <p class="text-xs text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>
            @if($action)
                <div class="flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-5">
        {{ $slot }}
    </div>
</div>
