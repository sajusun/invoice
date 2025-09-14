<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Invozen') }}</title>
    {{ $styles ?? '' }}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-50">
<div class="min-h-screen flex flex-col">
    @isset($header)
        <header>
            {{ $header }}
        </header>
    @else
        <header
            class="header bg-white shadow-sm flex items-center justify-between px-6 md:px-16 h-16 sticky top-0 z-50 transition">
            <div class="flex items-center">
                <a href="/"><h1 class="text-2xl font-bold text-primary">{{$app_name??'Invozen'}}</h1></a>
            </div>
            @include('custom-components.dashboard_auth')
        </header>
    @endisset
    <main>
        {{ $slot }}
    </main>
</div>
{{-- Extra Scripts --}}
{{ $scripts ?? '' }}
</body>
</html>
