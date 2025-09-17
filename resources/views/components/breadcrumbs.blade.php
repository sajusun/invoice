@php
    $segments = request()->segments();
    $url = '';
@endphp

<nav class="text-sm text-gray-600 mb-8">
    <ol class="list-reset flex">
        <!-- Home Link -->
        <li>
            <a href="{{ url('/') }}" class="hover:text-primary">Home</a>
        </li>

        @foreach ($segments as $index => $segment)
            @php
                $url .= '/' . $segment;
                $isLast = $index === array_key_last($segments);
            @endphp

            <li><span class="mx-2">›</span></li>
            <li>
                @if ($isLast)
                    <span class="text-gray-500 capitalize">{{ str_replace('-', ' ', $segment) }}</span>
                @else
                    <a href="{{ url($url) }}" class="hover:text-primary capitalize">
                        {{ str_replace('-', ' ', $segment) }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
