<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ config('app.url', env('APP_URL')) }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    @isset($meta)
        {{ $meta }}
    @endisset
    <title>{{ $title ?? (config('app.name', 'Invozen') . ' - Smart Invoicing Platform') }}</title>
    {{ $styles ?? '' }}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 min-h-full flex flex-col selection:bg-indigo-600 selection:text-white">
<div class="min-h-screen flex flex-col">
    @isset($header)
        {{ $header }}
    @else
        @include('custom-components.home-nav')
    @endisset

    <main class="flex-1">
        {{ $slot }}
    </main>
</div>

{{-- Extra Scripts --}}
{{ $scripts ?? '' }}
</body>
</html>
