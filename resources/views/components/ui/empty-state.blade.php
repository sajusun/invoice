@props([
    'icon' => 'fa-solid fa-folder-open',
    'title' => 'No records found',
    'description' => 'Get started by creating your first item.',
    'actionLabel' => null,
    'actionUrl' => null,
    'actionIcon' => 'fa-solid fa-plus',
])

<div class="text-center py-12 px-4 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50">
    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 text-2xl shadow-sm">
        <i class="{{ $icon }}"></i>
    </div>
    <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $title }}</h3>
    <p class="text-sm text-slate-500 max-w-sm mx-auto mb-6">{{ $description }}</p>

    @if($actionLabel && $actionUrl)
        <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-200 transition-all hover:shadow-lg hover:-translate-y-0.5">
            <i class="{{ $actionIcon }}"></i>
            <span>{{ $actionLabel }}</span>
        </a>
    @endif

    {{ $slot }}
</div>
