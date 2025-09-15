<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($head)
        {{$head}}
    @endisset
    <title>{{ $title ?? config('app.name', 'Invozen') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/guest.css', 'resources/js/guest.js'])
</head>
<body>
<div class="bg-gray-50">
    <!-- Page Heading -->
    @isset($header)
        @if($header!='')
            <header id="header" class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @else
            {{$header}}
        @endif

    @else
        <header id="header" class="bg-white shadow-sm sticky top-0 z-50">
            @include('custom-components.home-nav')
        </header>

    @endisset
    <main>
        {{ $slot }}
    </main>
</div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMenuButton = document.getElementById('close-menu');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.add('visible');
            document.body.style.overflow = 'hidden';
        });

        closeMenuButton.addEventListener('click', function () {
            mobileMenu.classList.remove('visible');
            document.body.style.overflow = 'auto';
        });

        // Close menu when clicking on links
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        });
    });
</script>
</html>
