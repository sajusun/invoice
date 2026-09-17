<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? (config('app.name', 'Invozen') . ' - Secure Authentication') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-gradient-to-br from-slate-50 via-indigo-50/20 to-slate-100 min-h-full flex flex-col justify-center selection:bg-indigo-600 selection:text-white py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-bold text-2xl shadow-xl shadow-indigo-200 group-hover:scale-105 transition-transform">
                        ⚡
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-2xl font-extrabold tracking-tight text-slate-900 leading-none">Invozen</span>
                        <span class="text-[10px] font-semibold text-indigo-600 uppercase tracking-wider mt-0.5">Smart Invoicing</span>
                    </div>
                </a>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-6 sm:px-10 shadow-xl shadow-slate-200/50 rounded-3xl border border-slate-100 backdrop-blur-sm">
                    {{ $slot }}
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
