<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($meta)
        {{$meta}}
    @endisset
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
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
        <header id="header" class="bg-white shadow-sm sticky top-0 z-50">
            <div class="header flex items-center justify-between transition max-w-7xl h-16 mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <a href="/"><h1 class="text-2xl font-bold text-primary">{{$app_name??'Invozen'}}</h1></a>
            </div>
            @guest()
                <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                           class="hidden md:block text-gray-600 hover:text-primary transition-colors">Sign In</a>
                        <a href="{{ route('register') }}"
                           class="hidden md:block bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">Sign Up</a>
                </div>
            @endguest
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
