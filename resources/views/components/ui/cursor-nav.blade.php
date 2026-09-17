@props([
    'paginator',
])

@if($paginator instanceof \Illuminate\Pagination\CursorPaginator && ($paginator->hasMorePages() || $paginator->previousCursor()))
    <div class="flex items-center justify-between px-4 py-3 bg-white border-t border-slate-100 sm:px-6 rounded-b-2xl">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                ⚡ Cursor Mode
            </span>
            <span class="text-xs text-slate-500">
                Showing {{ $paginator->count() }} items ({{ $paginator->perPage() }}/page)
            </span>
        </div>
        <div class="flex items-center gap-2">
            @if($paginator->previousCursor())
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    <span>Previous</span>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-100 text-xs font-semibold text-slate-300 cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    <span>Previous</span>
                </span>
            @endif

            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                    <span>Next</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            @else
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-100 text-xs font-semibold text-slate-300 cursor-not-allowed">
                    <span>Next</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </span>
            @endif
        </div>
    </div>
@elseif($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $paginator->hasPages())
    <div class="px-4 py-3 bg-white border-t border-slate-100 sm:px-6 rounded-b-2xl">
        {{ $paginator->links() }}
    </div>
@endif
