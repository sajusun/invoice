<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($meta)
        {{$meta}}
    @endisset
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/js/app.js'])
</head>
<body>
<div class="bg-gray-50">
    @isset($header)
        {{$header}}
    @else
        @include('custom-components.home-nav')
    @endisset
    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>
