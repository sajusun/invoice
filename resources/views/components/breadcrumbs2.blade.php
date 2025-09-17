@props(['links' => []])

<nav class="flex text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach ($links as $label => $url)
            <li class="inline-flex items-center">
                @if (!$loop->first)
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9
                        7.293 4.707a1 1 0 111.414-1.414l5 5a1 1 0
                        010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                @endif

                @if ($url)
                    <a href="{{ $url }}" class="inline-flex items-center text-gray-600 hover:text-primary">
                        {{ $label }}
                    </a>
                @else
                    <span class="text-gray-400">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

{{--how to use sample --}}
{{--<x-breadcrumbs :links="[--}}
{{--    'Dashboard' => route('dashboard'),--}}
{{--    'Payments' => route('payments.index'),--}}
{{--    'Invoice #1234' => null--}}
{{--]" />--}}
