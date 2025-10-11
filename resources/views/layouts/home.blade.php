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
    @vite(['resources/css/guest.css', 'resources/js/bootstrap.js'])
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

</body>
</html>
